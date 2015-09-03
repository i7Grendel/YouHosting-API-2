<?php
/**
 * Created by PhpStorm.
 * User: hans
 * Date: 31-8-15
 * Time: 21:43
 */

namespace YouHosting;


class YouHosting
{
    protected $api;

    /**
     * Create a new instance of YouHosting
     *
     * @param $username string Your YouHosting administrator e-mail
     * @param $password string Your YouHosting password
     * @param array $options an array of options
     * @param string $apiKey (optional) Your SVIP API key (if you have the SVIP plan, using this is highly recommended)
     */
    public function __construct($username, $password, $options = array(), $apiKey = null)
    {
        if(empty($apiKey)){
            $this->api = new WebApi($username, $password, $options);
        } else {
            $this->api = new RestApi($username, $password, $options, $apiKey);
        }
    }

    /**
     * Get the client ID from a Client object, e-mail or id
     *
     * @param Client|string|int $client
     * @return int
     * @throws YouHostingException
     */
    protected function getClientId($client)
    {
        if($client instanceof Client){
            if(!empty($client->id)) {
                $id = $client->id;
            } elseif(!empty($client->email)){
                $id = $this->api->searchClientId($client->email);
            } else {
                throw new YouHostingException("You need to provide either a client ID (recommended) or client e-mail to search for");
            }
        } elseif (is_numeric($client)) {
            $id = $client;
        } else {
            $id = $this->api->searchClientId($client);
        }

        return (int)$id;
    }

    /**
     * Get a client from YouHosting
     *
     * @param mixed $client An instance of a Client or a client ID
     * @return Client
     * @throws YouHostingException
     */
    public function getClient($client)
    {
        return $this->api->getClient($this->getClientId($client));
    }

    /**
     * Create a new client on YouHosting
     *
     * @param Client $client a container for client details
     * @param string $password
     * @param int $captchaId
     * @return Client
     * @throws YouHostingException
     */
    public function createClient(Client $client, $password, $captchaId = null)
    {
        return $this->api->createClient($client, $password, $captchaId);
    }

    public function getAccount($account)
    {
        return $this->api->getAccount($this->getAccountId($account));
    }

    protected function getAccountId($account)
    {
        if($account instanceof Account){
            if(!empty($account->id)){
                $id = $account->id;
            } elseif(!empty($account->domain)){
                $id = $this->api->searchAccountId($account->domain);
            } else {
                throw new YouHostingException("You need to provide either an account ID (recommended) or account domain to search for");
            }
        } elseif(is_numeric($account)){
            $id = $account;
        } else {
            $id = $this->api->searchAccountId($account);
        }

        return $id;
    }

    /**
     * Get a new captcha (SVIP API only)
     *
     * @return array containing a numeric id and a url to the captcha image
     */
    public function getCaptcha()
    {
        return $this->api->getCaptcha();
    }

    /**
     * Verify the captcha result (SVIP API only)
     *
     * @param int $id the captcha id
     * @param string $solution the solution of the captcha submitted by the user
     * @return boolean
     */
    public function checkCaptcha($id, $solution)
    {
        return $this->api->checkCaptcha($id, $solution);
    }

    /**
     * Get a list of clients
     *
     * Returns array with the parameter list (containing an array of Client objects) and per_page (telling you the number of clients.
     * When using the SVIP API, you also get pages (the total number of pages), and total (the total number of clients for the reseller)
     *
     * @param int $page optional the page number
     * @return array
     */
    public function listClients($page = 1)
    {
        return $this->api->listClients($page);
    }

    /**
     * Get the login URL for a client
     *
     * @param Client|string|int a client object, client e-mail (not recommended) or client ID
     * @return mixed
     */
    public function getLoginUrl($client)
    {
        return $this->api->getClientLoginUrl($this->getClientId($client));
    }

    public function getLoginUrlAccount($account)
    {

    }

    public function checkDomain($type, $domain, $subdomain = "")
    {

    }

    public function listAccounts($page = 1)
    {

    }

    public function suspendAccount($account, $reason = "")
    {

    }

    public function suspendClient($client, $reason = "")
    {

    }

    public function unsuspendAccount($account, $reason = "")
    {

    }

    public function unsuspendClient($client, $reason = "")
    {

    }

    public function deleteAccount($id)
    {

    }

    public function getSubdomains()
    {

    }

    public function getPlans()
    {

    }

    public function getNameservers()
    {

    }

}