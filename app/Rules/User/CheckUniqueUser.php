<?php


namespace App\Rules\User;


use App\Zen\System\Model\Customer;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CheckUniqueUser implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $unAvailableUsersArray = $this -> unAvailableUsers();

        return !in_array($value, $unAvailableUsersArray);
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return trans('master.Sorry the user already exists in our system.');
    }

    /**
     * @return array
     */
    public function unAvailableUsers(): array
    {
        $duplicateAllowed = config('zenlease.duplicate_allowed_users');

        $unAvailableEmailsArray = config('zenlease.blacklist_email_users');

        $alreadyEmails = DB ::connection('system') -> table('users') -> whereNotIn('email', $duplicateAllowed) -> get() -> pluck('email') -> toArray();

        $unAvailableEmailsArray = array_merge($unAvailableEmailsArray, $alreadyEmails);

        return $unAvailableEmailsArray;
    }
}