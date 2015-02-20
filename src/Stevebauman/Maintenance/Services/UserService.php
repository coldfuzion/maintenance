<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\User;

/**
 * Class UserService
 * @package Stevebauman\Maintenance\Services
 */
class UserService extends BaseModelService
{

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var LdapService
     */
    protected $ldap;

    /**
     * @param User $user
     * @param SentryService $sentry
     * @param LdapService $ldap
     */
    public function __construct(User $user, SentryService $sentry, LdapService $ldap)
    {
        $this->model = $user;
        $this->sentry = $sentry;
        $this->ldap = $ldap;
    }

    /**
     * Returns a filtered and paginated collection of users
     *
     * @return mixed
     */
    public function getByPageWithFilter()
    {
        return $this->model
            ->id($this->getInput('id'))
            ->name($this->getInput('name'))
            ->username($this->getInput('username'))
            ->email($this->getInput('email'))
            ->paginate(25);
    }

    /**
     * Create or Update a User for authentication for use with ldap
     *
     * @author Steve Bauman
     *
     * @param $credentials
     * @return void
     */
    public function createOrUpdateUser($credentials)
    {
        $login_attribute = config('cartalyst/sentry::users.login_attribute');

        $username = $credentials[$login_attribute];
        $password = $credentials['password'];

        // If a user is found, update their password to match active-directory
        $user = $this->model->where('username', $username)->first();

        if ($user) {

            $this->sentry->updatePasswordById($user->id, $password);

        } else {

            // If a user is not found, create their web account
            $ldapUser = $this->ldap->user($username);

            $fullname = explode(',', $ldapUser->name);
            $last_name = (array_key_exists(0, $fullname) ? $fullname[0] : NULL);
            $first_name = (array_key_exists(1, $fullname) ? $fullname[1] : NULL);

            $data = array(
                'email' => $ldapUser->email,
                'password' => $password,
                'username' => $username,
                'last_name' => (string)$last_name,
                'first_name' => (string)$first_name,
            );

            $user = $this->sentry->createUser($data);
        }

        return $user;
    }

}