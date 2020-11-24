<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Mail\UserVerifiedNotify;
use App\Zen\Setting\Model\AdminSetting;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\System\Service\ModuleAvailabilityService;
use App\Zen\User\Model\Role;
use App\Zen\User\Model\User;
use App\Zen\User\Model\UserRepository as UserRepo;
use App\Zen\User\NotificationSetting\DatabaseToFormArray;
use App\Zen\User\Service\UserService;
use App\Zen\User\UserList\AllUser;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use TechTailor\RPG\Facade\RPG;


class UserController extends Controller
{
    use AllUser;
    /**
     * @var UserRepo
     */
    private $userRepo;
    /**
     * @var
     */
    private $passwordBroker;

    public function __construct(UserRepo $userRepo, PasswordBroker $passwordBroker)
    {
        $this -> middleware('checkAdmin') -> only('verify', 'verifyPost');
        $this -> middleware('moduleNumber:User') -> only(['create', 'store']);
        $this -> userRepo = $userRepo;
        $this->passwordBroker = $passwordBroker;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this -> checkAllowAccess('view_user');
        $view['add_user']=$this -> checkAllowAccessWithoutException('edit_user') && ModuleAvailabilityService ::availabilityCount('User');
        $users = User ::nonDevelopers() -> orderBy('name') -> get();
        $roles = Role ::get();
        foreach($users as $user) {
            $roleArray = [];
            foreach($user -> roles as $userRole)
                array_push($roleArray, $userRole -> id);
            foreach($roles as $role) {
                $user[$role -> name] = 0;
                if(in_array($role -> id, $roleArray))
                    $user[$role -> name] = 1;
            }
        }
        $userCounterparties = User ::nonDevelopers() -> with('counterparties') -> where(['active_status' => 1, 'verified' => 1]) -> orderBy('name') -> get();
        $counterparties = Counterparty ::entity() -> orderBy('short_name') -> get();
        foreach($userCounterparties as $user) {
            $counterpartyArray = [];
            foreach($user -> counterparties as $userCounterparty)
                array_push($counterpartyArray, $userCounterparty -> id);
            foreach($counterparties as $counterparty) {
                $user[$counterparty -> short_name] = 0;
                if(in_array($counterparty -> id, $counterpartyArray))
                    $user[$counterparty -> short_name] = 1;
            }

        }
        return view('User.users.index', compact('users', 'roles', 'counterparties', 'userCounterparties','view'));
    }


    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $counterparties = Counterparty::entity()->orderBy('short_name')->get();
        $roles = Role::where('id', '<>', 1)->orderBy('label')->get();
        $roleArray = [];
        $counterpartyArray = [];
        return view('new_account', compact('counterparties', 'roles', 'roleArray', 'counterpartyArray'));
    }

    /**
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userRepo->handleCreate($request);

        //Generate password reset token and send new invitation mail
        $token = $this->passwordBroker->createToken($user);

        $url = Url('password/reset/' . $token . '?email=' . $user->email);
        Mail::to($user->email)->send(new UserVerifiedNotify($url, $user->roles, $user));
        flash()->overlay(trans('The user has been invited by email'), 'Success')->message();
        return redirect()->route('users.index');

    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function edit(User $user)
    {

        if(\auth()->id() != $user->id)
            $this->checkAllowAccess('edit_user');

        $counterparties = Counterparty::entity()->orderBy('short_name')->get();
        $roleArray = [];
        foreach($user->roles as $userRole)
            array_push($roleArray, $userRole->id);

        $counterpartyArray = [];
        foreach($user->counterparties as $userCounterparty)
            array_push($counterpartyArray, $userCounterparty->id);

        $roles = Role::where('id', '<>', 1)->get();

        $maturingNotifications = DatabaseToFormArray::maturingNotificationDays($user->id);

        $buttonShow['email_notifications'] = ModuleAvailabilityService::checkEmailNotificationsAvailability();
        return view('User.users.edit', compact('user', 'roles', 'roleArray',
            'counterparties', 'counterpartyArray', 'maturingNotifications','buttonShow'));

    }

    public function broker()
    {
        return Password::broker();
    }

    /**
     * Get the response for a failed password reset link.
     * @param \Illuminate\Http\Request $request
     * @param string $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()->withErrors(
            ['email' => trans($response)]
        );
    }

    public function update(StoreUserRequest $request, $id)

    {

        switch($request->input('submit')){
            case 'reset':
                Auth::logout();
                return redirect()->route('password.request')->with('status', 'Please enter your email.');
            case 'save':
                if(\auth()->id() != $id)
                    $this->checkAllowAccess('edit_user');
                $this->userRepo->updateUserDetails($request, $id);
                return back();
            default:
                return back();
                break;
        }


    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function verify($userId)
    {
        $user = $this->userRepo->find($userId);
        $roles = Role::where('id', '<>', 1)->where('id', '<>', 2)->get();
        $userRoles = $user->roles;
        if($user->verified)
            flash()->overlay('User is verified')->message();
        else
            flash()->overlay('Please verify the user')->message();
        return view('User.users.verification', compact('user', 'roles', 'userRoles'));
    }

    public function postVerify(Request $request)
    {
        $request->validate([
            'role' => 'required'
        ]);
        $this->userRepo->verifyUserAndRole($request);
        return back();
    }

}
