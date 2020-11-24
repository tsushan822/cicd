<?php

namespace App\Rules\User;

use App\Zen\System\Model\Customer;
use Illuminate\Contracts\Validation\Rule;

class UserEmailDomain implements Rule
{
    /**
     * Create a new rule instance.
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $availableDomainsArray = $this -> availableDomainsForUserCreate();

        array_walk($availableDomainsArray, 'trim');
        $providedUserDomain = explode("@", $value);

        if(in_array($providedUserDomain[1], $availableDomainsArray)) {
            return true;
        }
        return false;

    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message()
    {
        return trans('master.Sorry! the user email domain is not valid. Please contact system administrator');
    }

    /**
     * @return array
     */
    private function availableDomainsForUserCreate(): array
    {
        $website = app(\Hyn\Tenancy\Environment::class) -> tenant();
        $availableDomains = Customer ::where('website_id', $website -> id) -> first() -> user_domains;
        $availableDomainsArray = explode(",", $availableDomains);

        //default domains name
        $defaultArrays = ['zentreasury.com'];
        $availableDomainsArray= array_unique(array_merge($availableDomainsArray,$defaultArrays));

        return $availableDomainsArray;
    }

}
