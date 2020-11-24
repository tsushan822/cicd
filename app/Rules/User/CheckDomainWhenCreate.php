<?php

namespace App\Rules\User;

use App\Zen\System\Model\Customer;
use Illuminate\Contracts\Validation\Rule;

class CheckDomainWhenCreate implements Rule
{

    private $alreadyExit = false;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(request() -> input('invitation'))
            return true;

        $providedUserDomain = explode("@", $value);

        if($this -> unAvailableDomainsForUserCreate($providedUserDomain[1])) {
            $this -> alreadyExit = true;
            return false;
        }

        if($this -> blockListedDomainsForUserCreate($providedUserDomain[1])) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if($this -> alreadyExit)
            return trans('master.Sorry the user domain already exist');

        return trans('master.Please register with a company email domain. Free email domains (gmail, yahoo, hotmail, etc.) aren’t allowed');
    }

    /**
     * @return boolean
     */
    public function unAvailableDomainsForUserCreate($providedUserDomain): bool
    {
        $duplicateAllowed = config('zenlease.duplicate_allowed_domains');

        $alreadyDomains = Customer ::whereNotIn('user_domains', $duplicateAllowed) -> get() -> pluck('user_domains') -> toArray();

        return in_array($providedUserDomain, $alreadyDomains);

    }

    /**
     * @return array
     */
    public function blockListedDomainsForUserCreate($providedUserDomain): bool
    {

        $unAvailableDomainsArray = config('zenlease.blacklist_email');

        return in_array($providedUserDomain, $unAvailableDomainsArray);
    }
}
