<?php

namespace KernelBundle\Service;


use KernelBundle\Entity\MailingList;
use KernelBundle\Entity\User;
use Ovh\Api;

class OVHMailManager
{

    // --- wrapper functions related consts
    // ---- GET --------------------------------
    const FUNC_LIST_DOMAINS = "_func_available_services";            // List available services
    const FUNC_DOMAIN_PROPERTIES = "_func_domain_properties";                // Get this object properties
    const FUNC_LIST_ACCOUNTS = "_func_list_accounts";                    // Get accounts
    const FUNC_ACCOUNT_PROPERTIES = "_func_account_properties";            // Get this object properties
    const FUNC_LIST_FILTERS = "_func_list_filters";                    // Get filters
    const FUNC_FILTER_PROPERTIES = "_func_filter_properties";                // Get this object properties
    const FUNC_LIST_RULES = "_func_list_rules";                    // Get rules
    const FUNC_RULE_PROPERTIES = "_func_rule_properties";                // Get this object properties
    const FUNC_ACCOUNT_USAGE = "_func_account_usage";                    // usage of account
    const FUNC_LIST_ACL = "_func_list_acl";                        // Get ACL on your domain
    const FUNC_ACL_PROPERTIES = "_func_acl_properties";                // Get this object properties
    const FUNC_LIST_MXFILTERS = "_func_list_mxfilters";                // Domain MX filter
    const FUNC_LIST_MXRECORDS = "_func_list_mxrecords";                // Domain MX records
    const FUNC_LIST_MAILLISTS = "_func_list_maillists";                // Get mailing lists
    const FUNC_MAILLIST_PROPERTIES = "_func_maillist_properties";            // Get this object properties
    const FUNC_LIST_MODERATORS = "_func_list_moderators";                // List of moderators
    const FUNC_MODERATOR_PROPERTIES = "_func_moderator_properties";            // Get this object properties
    const FUNC_LIST_SUBSCRIBERS = "_func_list_subscribers";                // List of subscribers
    const FUNC_SUBSCRIBER_PROPERTIES = "_func_subscriber_properties";            // Get this object properties
    const FUNC_LIST_QUOTAS = "_func_list_quotas";                    // List all quotas for this domain
    const FUNC_LIST_REDIRECTIONS = "_func_list_redirections";                // Get redirections
    const FUNC_REDIRECTION_PROPERTIES = "_func_redirection_properties";        // Get this object properties
    const FUNC_LIST_RESPONDERS = "_func_list_responders";                // Get responders
    const FUNC_RESPONDER_PROPERTIES = "_func_responder_properties";            // Get this object properties
    const FUNC_SERVICES_INFO = "_func_services_info";                    // Get this object properties
    const FUNC_SUMMARY = "_func_summary";                        // Summary for this domain
    const FUNC_LIST_ACCOUNT_TASKS = "_func_list_account_tasks";            // Get account tasks
    const FUNC_ACCOUNT_TASK_PROPERTIES = "_func_account_task_properties";        // Get this object properties
    const FUNC_LIST_FILTER_TASKS = "_func_list_filter_tasks";                // Get filter tasks
    const FUNC_FILTER_TASK_PROPERTIES = "_func_filter_task_properties";        // Get this object properties
    const FUNC_LIST_MAILLIST_TASKS = "_func_list_maillist_tasks";            // Get Mailing List tasks
    const FUNC_MAILLIST_TASK_PROPERTIES = "_func_maillist_task_properties";        // Get this object properties
    const FUNC_LIST_REDIRECTION_TASKS = "_func_list_redirection_tasks";        // Get redirection tasks
    const FUNC_REDIRECTION_TASK_PROPERTIES = "_func_redirection_task_properties";    // Get this object properties
    const FUNC_LIST_RESPONDER_TASKS = "_func_list_responder_tasks";            // Get responder tasks
    const FUNC_RESPONDER_TASK_PROPERTIES = "_func_responder_task_properties";        // Get this object properties
    // ---- PUT --------------------------------
    const FUNC_UPDATE_ACCOUNT = "_func_update_account";                // Alter this object properties
    const FUNC_UPDATE_MAILLIST = "_func_update_maillist";                // Alter this object properties
    const FUNC_UPDATE_RESPONDER = "_func_update_responder";                // Alter this object properties
    const FUNC_UPDATE_SERVICES_INFO = "_func_update_services_info";            // Alter this object properties
    // ---- POST ------------------------------
    const FUNC_CREATE_MAILBOX = "_func_create_mailbox";                    // Create new mailbox in server
    const FUNC_CHANGE_MAILBOX_PWD = "_func_change_mailbox_pwd";                // Change mailbox password (length in [9;30], trimmed, no accent)
    const FUNC_CREATE_FILTER = "_func_create_filter";                    // Create new filter for account
    const FUNC_CHANGE_FILTER_ACTIVITY = "_func_change_filter_activity";            // Change filter activity
    const FUNC_CHANGE_FILTER_PRIORITY = "_func_change_filter_priority";            // Change filter priority
    const FUNC_CREATE_RULE = "_func_create_rule";                        // Create a new rule for filter
    const FUNC_UPDATE_ACCOUNT_USAGE = "_func_update_account_usage";            // Update usage of account
    const FUNC_CREATE_ACL = "_func_create_acl";                        // Create a new ACL
    const FUNC_CHANGE_CONTACT = "_func_change_contact";                    // Launch a contact change procedure
    const FUNC_CHANGE_MXFILTER = "_func_change_mxfilter";                    // Change MX filter, so change MX DNS records
    const FUNC_CREATE_MAILLIST = "_func_create_maillist";                    // Create a new mailing list
    const FUNC_CHANGE_MAILLIST_OPTS = "_func_change_maillist_opts";            // Change mailing list options
    const FUNC_ADD_MODERATOR = "_func_add_moderator";                    // Add moderator to mailing list
    const FUNC_SEND_MAILLIST_BY_MAIL = "_func_send_maillist_by_mail";            // Send moderators list and subscribers list of this mailing list by email
    const FUNC_ADD_SUBSCRIBER = "_func_add_subscriber";                    // Add subscriber to mailing list
    const FUNC_CREATE_DOMAIN_DELEG = "_func_create_domain_deleg";                // Create delegation of domain with same nic than V3
    const FUNC_CREATE_REDIRECTION = "_func_create_redirection";                // Create new redirection in server
    const FUNC_CHANGE_REDIRECTION = "_func_change_redirection";                // Change redirection
    const FUNC_CREATE_RESPONDER = "_func_create_responder";                // Create new responder in server
    // ---- DELETE ----------------------------
    const FUNC_REMOVE_MAILBOX = "_func_remove_mailbox";        // Delete an existing mailbox in server
    const FUNC_REMOVE_FILTER = "_func_remove_filter";        // Delete an existing filter
    const FUNC_REMOVE_RULE = "_func_remove_rule";            // Delete an existing rule
    const FUNC_REMOVE_ACL = "_func_remove_acl";            // Delete ACL
    const FUNC_REMOVE_MAILLIST = "_func_remove_maillist";        // Delete existing Mailing list
    const FUNC_REMOVE_MODERATOR = "_func_remove_moderator";    // Delete existing moderator
    const FUNC_REMOVE_SUBSCRIBER = "_func_remove_subscriber";    // Delete existing subscriber
    const FUNC_REMOVE_REDIRECTION = "_func_remove_redirection";    // Delete an existing redirection in server
    const FUNC_REMOVE_RESPONDER = "_func_remove_responder";    // Delete an existing responder in server
    // --- commands substitution arguments ----
    const ARG_DOMAIN = "{domain}";
    const ARG_NAME = "{name}";
    const ARG_ID = "{id}";
    const ARG_EMAIL = "{email}";
    const ARG_ACCOUNT = "{account}";
    const ARG_ACCOUNT_ID = "{accountId}";
    const ARG_ACCOUNT_NAME = "{accountName}";
    // --- post parameters --------------------
    const PARAM_DOMAIN = "domain";
    const PARAM_ACCOUNT_NAME = "accountName";
    const PARAM_PASSWORD = "password";
    const PARAM_LANGUAGE = "language";
    const PARAM_NAME = "name";
    const PARAM_OPTIONS = "options";
    const PARAM_OWNER_EMAIL = "ownerEmail";
    const PARAM_REPLY_TO = "replyTo";
    const PARAM_EMAIL = "email";
    // --- options
    const OPTION_MODERATOR_MESSAGE = "moderatorMessage";
    const OPTION_SUBSCRIBE_BY_MODERATOR = "subscribeByModerator";
    const OPTION_USERS_POST_ONLY = "usersPostOnly";
    // --- const params -----------------------
    const P_DESCRIPTION = "description";
    const P_PWD = "password";
    const P_SIZE = "size"; //(in bytes/en octets)
    const P_ACTIVITY = "activity";
    const P_PRIORITY = "priority";
    const P_TO = "to";
    const P_CREATE_FILTER_CONFIG = "create_filter_config";
    const P_CREATE_RULE_CONFIG = "create_rule_config";
    const P_CONTACT_CONFIG = "contact_config";
    const P_MXFILTER_CONFIG = "mxfilter_config";
    const P_CREATE_MAILLIST_CONFIG = "maillist_config";
    const P_MAILLIST_OPTIONS = "maillist_options";
    const P_REDIRECTION_CONFIG = "redirection_config";
    const P_RESPONDER_CONFIG = "responder_config";
    const P_UPDATE_ACCOUNT = "update_account_config";
    const P_UPDATE_MAILLIST = "update_maillist_config";
    const P_UPDATE_RESPONDER = "update_responder_config";
    const P_UPDATE_SERVICE_INFO = "update_service_info_config";

    // --- commands dictionaries sorted by GET, PUT, POST, DELETE
    const GET_COMMANDS = [
        self::FUNC_LIST_DOMAINS => "/email/domain",
        self::FUNC_DOMAIN_PROPERTIES => "/email/domain/{domain}",
        self::FUNC_LIST_ACCOUNTS => "/email/domain/{domain}/account",
        self::FUNC_ACCOUNT_PROPERTIES => "/email/domain/{domain}/account/{accountName}",
        self::FUNC_LIST_FILTERS => "/email/domain/{domain}/account/{accountName}/filter",
        self::FUNC_FILTER_PROPERTIES => "/email/domain/{domain}/account/{accountName}/filter/{name}",
        self::FUNC_LIST_RULES => "/email/domain/{domain}/account/{accountName}/filter/{name}/rule",
        self::FUNC_RULE_PROPERTIES => "/email/domain/{domain}/account/{accountName}/filter/{name}/rule/{id}",
        self::FUNC_ACCOUNT_USAGE => "/email/domain/{domain}/account/{accountName}/usage",
        self::FUNC_LIST_ACL => "/email/domain/{domain}/acl",
        self::FUNC_ACL_PROPERTIES => "/email/domain/{domain}/acl/{accountId}",
        self::FUNC_LIST_MXFILTERS => "/email/domain/{domain}/dnsMXFilter",
        self::FUNC_LIST_MXRECORDS => "/email/domain/{domain}/dnsMXRecords",
        self::FUNC_LIST_MAILLISTS => "/email/domain/{domain}/mailingList",
        self::FUNC_MAILLIST_PROPERTIES => "/email/domain/{domain}/mailingList/{name}",
        self::FUNC_LIST_MODERATORS => "/email/domain/{domain}/mailingList/{name}/moderator",
        self::FUNC_MODERATOR_PROPERTIES => "/email/domain/{domain}/mailingList/{name}/moderator/{email}",
        self::FUNC_LIST_SUBSCRIBERS => "/email/domain/{domain}/mailingList/{name}/subscriber",
        self::FUNC_SUBSCRIBER_PROPERTIES => "/email/domain/{domain}/mailingList/{name}/subscriber/{email}",
        self::FUNC_LIST_QUOTAS => "/email/domain/{domain}/quota",
        self::FUNC_LIST_REDIRECTIONS => "/email/domain/{domain}/redirection",
        self::FUNC_REDIRECTION_PROPERTIES => "/email/domain/{domain}/redirection/{id}",
        self::FUNC_LIST_RESPONDERS => "/email/domain/{domain}/responder",
        self::FUNC_RESPONDER_PROPERTIES => "/email/domain/{domain}/responder/{account}",
        self::FUNC_SERVICES_INFO => "/email/domain/{domain}/serviceInfos",
        self::FUNC_SUMMARY => "/email/domain/{domain}/summary",
        self::FUNC_LIST_ACCOUNT_TASKS => "/email/domain/{domain}/task/account",
        self::FUNC_ACCOUNT_TASK_PROPERTIES => "/email/domain/{domain}/task/account/{id}",
        self::FUNC_LIST_FILTER_TASKS => "/email/domain/{domain}/task/filter",
        self::FUNC_FILTER_TASK_PROPERTIES => "/email/domain/{domain}/task/filter/{id}",
        self::FUNC_LIST_MAILLIST_TASKS => "/email/domain/{domain}/task/mailinglist",
        self::FUNC_MAILLIST_TASK_PROPERTIES => "/email/domain/{domain}/task/mailinglist/{id}",
        self::FUNC_LIST_REDIRECTION_TASKS => "/email/domain/{domain}/task/redirection",
        self::FUNC_REDIRECTION_TASK_PROPERTIES => "/email/domain/{domain}/task/redirection/{id}",
        self::FUNC_LIST_RESPONDER_TASKS => "/email/domain/{domain}/task/responder",
        self::FUNC_RESPONDER_TASK_PROPERTIES => "/email/domain/{domain}/task/responder/{id}"
    ];
    const PUT_COMMANDS = [
        self::FUNC_UPDATE_ACCOUNT => "/email/domain/{domain}/account/{accountName}",
        self::FUNC_UPDATE_MAILLIST => "/email/domain/{domain}/mailingList/{name}",
        self::FUNC_UPDATE_RESPONDER => "/email/domain/{domain}/responder/{account}",
        self::FUNC_UPDATE_SERVICES_INFO => "/email/domain/{domain}/serviceInfos"
    ];
    const POST_COMMANDS = [
        self::FUNC_CREATE_MAILBOX => "/email/domain/{domain}/account",
        // params(domain, accountName, description, password, size(in bytes))
        self::FUNC_CHANGE_MAILBOX_PWD => "/email/domain/{domain}/account/{accountName}/changePassword",
        // params(domain, accountName, password)
        self::FUNC_CREATE_FILTER => "/email/domain/{domain}/account/{accountName}/filter",
        // params(domain, accountName, action, actionParam, active, header, name, operand, priority, value)
        self::FUNC_CHANGE_FILTER_ACTIVITY => "/email/domain/{domain}/account/{accountName}/filter/{name}/changeActivity",
        // params(domain, name, accountName, activity)
        self::FUNC_CHANGE_FILTER_PRIORITY => "/email/domain/{domain}/account/{accountName}/filter/{name}/changePriority",
        // params(domain, name, accountName, priority)
        self::FUNC_CREATE_RULE => "/email/domain/{domain}/account/{accountName}/filter/{name}/rule",
        // params(domain, name, accountName, header, operand, value)
        self::FUNC_UPDATE_ACCOUNT_USAGE => "/email/domain/{domain}/account/{accountName}/updateUsage",
        // params(domain, accountName)
        self::FUNC_CREATE_ACL => "/email/domain/{domain}/acl",
        // params(domain, accountId)
        self::FUNC_CHANGE_CONTACT => "/email/domain/{domain}/changeContact",
        // params(domain, contactAdmin, contactBilling, contactTech)
        self::FUNC_CHANGE_MXFILTER => "/email/domain/{domain}/changeDnsMXFilter",
        // params(domain, customTarget, mxFilter, subDomain)
        self::FUNC_CREATE_MAILLIST => "/email/domain/{domain}/mailingList",
        // params(domain, language, name, options[moderatorMessage(bool),subscribeByModerator(bool),usersPostOnly(bool)],ownerEmail,replyTo)
        self::FUNC_CHANGE_MAILLIST_OPTS => "/email/domain/{domain}/mailingList/{name}/changeOptions",
        // params(domain, name, options[moderatorMessage(bool),subscribeByModerator(bool),usersPostOnly(bool)])
        self::FUNC_ADD_MODERATOR => "/email/domain/{domain}/mailingList/{name}/moderator",
        // params(domain, name, email)
        self::FUNC_SEND_MAILLIST_BY_MAIL => "/email/domain/{domain}/mailingList/{name}/sendListByEmail",
        // params(domain, name, email)
        self::FUNC_ADD_SUBSCRIBER => "/email/domain/{domain}/mailingList/{name}/subscriber",
        // params(domain, name, email)
        self::FUNC_CREATE_DOMAIN_DELEG => "/email/domain/{domain}/migrateDelegationV3toV6",
        // params(domain)
        self::FUNC_CREATE_REDIRECTION => "/email/domain/{domain}/redirection",
        // params(domain, from, localCopy(bool), to)
        self::FUNC_CHANGE_REDIRECTION => "/email/domain/{domain}/redirection/{id}/changeRedirection",
        // params(domain, id, to)
        self::FUNC_CREATE_RESPONDER => "/email/domain/{domain}/responder"
        // params(domain, account, content, copy, copyTo, from, to)
    ];
    const DELETE_COMMANDS = [
        self::FUNC_REMOVE_MAILBOX => "/email/domain/{domain}/account/{accountName}",
        self::FUNC_REMOVE_FILTER => "/email/domain/{domain}/account/{accountName}/filter/{name}",
        self::FUNC_REMOVE_RULE => "/email/domain/{domain}/account/{accountName}/filter/{name}/rule/{id}",
        self::FUNC_REMOVE_ACL => "/email/domain/{domain}/acl/{accountId}",
        self::FUNC_REMOVE_MAILLIST => "/email/domain/{domain}/mailingList/{name}",
        self::FUNC_REMOVE_MODERATOR => "/email/domain/{domain}/mailingList/{name}/moderator/{email}",
        self::FUNC_REMOVE_SUBSCRIBER => "/email/domain/{domain}/mailingList/{name}/subscriber/{email}",
        self::FUNC_REMOVE_REDIRECTION => "/email/domain/{domain}/redirection/{id}",
        self::FUNC_REMOVE_RESPONDER => "/email/domain/{domain}/responder/{account}"
    ];

    private $api;
    private $domain;
    private $language;

    public function __construct($endpoint, $applicationKey, $applicationSecret, $consumerKey, $domain, $language)
    {
        if (isset($endpoint) && isset($applicationKey) && isset($applicationSecret) && isset($consumerKey)) {
            $this->api = new Api(
                $applicationKey,
                $applicationSecret,
                $endpoint,
                $consumerKey
            );
        } else {
            $this->api = null;
        }
        $this->domain = $domain;
        $this->language = $language;
    }

    // -- Usable functions (add new ones following the same pattern if needed)

    // GET functions
    public function getMailingLists()
    {
        return $this->get(
            self::FUNC_LIST_MAILLISTS,
            [
                self::ARG_DOMAIN => $this->domain
            ]
        );
    }

    public function getMailingList(MailingList $mailingList)
    {
        return $this->get(
            self::FUNC_MAILLIST_PROPERTIES,
            [
                self::ARG_DOMAIN => $this->domain,
                self::ARG_NAME => $mailingList->getLabel()
            ]
        );
    }

    public function getMailingListSubscribers(MailingList $mailingList)
    {
        return $this->get(
            self::FUNC_LIST_SUBSCRIBERS,
            [
                self::ARG_DOMAIN => $this->domain,
                self::ARG_NAME => $mailingList->getLabel()
            ]
        );
    }

    // POST functions
    public function createAccount(User $user)
    {
        return $this->post(
            self::FUNC_CREATE_MAILBOX,
            [
                self::ARG_DOMAIN => $this->domain,
                self::PARAM_ACCOUNT_NAME => $user->getUsername(),
                self::PARAM_PASSWORD => $user->getPlainPassword()
            ]
        );
    }

    public function updatePassword(User $user)
    {
        return $this->post(
            self::FUNC_CHANGE_MAILBOX_PWD,
            [
                self::ARG_DOMAIN => $this->domain,
                self::ARG_ACCOUNT_NAME => $user->getUsername(),
                self::PARAM_PASSWORD => $user->getPlainPassword()
            ]
        );
    }

    public function createMailingList(MailingList $mailingList)
    {
        return $this->post(
            self::FUNC_CREATE_MAILLIST,
            [
                self::ARG_DOMAIN => $this->domain,
                self::PARAM_LANGUAGE => $this->language,
                self::PARAM_NAME => $mailingList->getLabel(),
                self::PARAM_OPTIONS => [
                    self::OPTION_MODERATOR_MESSAGE => $mailingList->isModeratorMessage(),
                    self::OPTION_SUBSCRIBE_BY_MODERATOR => $mailingList->isSubscribeByModerator(),
                    self::OPTION_USERS_POST_ONLY => $mailingList->isUsersPostOnly()
                ],
                self::PARAM_OWNER_EMAIL => $mailingList->getOwnerEmail(),
                self::PARAM_REPLY_TO => $mailingList->getReplyTo() !== null ?
                    $mailingList->getReplyTo() : $mailingList->getOwnerEmail()
            ]
        );
    }

    public function subscribeToMailingList(MailingList $mailingList, $email)
    {
        return $this->post(
            self::FUNC_ADD_SUBSCRIBER,
            [
                self::ARG_DOMAIN => $this->domain,
                self::ARG_NAME => $mailingList->getLabel(),
                self::PARAM_EMAIL => $email
            ]
        );
    }

    // PUT functions

    //DELETE functions
    public function deleteAccount(User $user)
    {
        return $this->delete(
            self::FUNC_REMOVE_MAILBOX,
            [
                self::ARG_DOMAIN => $this->domain,
                self::ARG_ACCOUNT_NAME => $user->getUsername()
            ]
        );
    }

    public function deleteMailingList(MailingList $mailingList)
    {
        return $this->delete(
            self::FUNC_REMOVE_MAILBOX,
            [
                self::ARG_DOMAIN => $this->domain,
                self::ARG_NAME => $mailingList->getLabel()
            ]
        );
    }

    public function removeFromMailingList(MailingList $mailingList, $email)
    {
        return $this->delete(
            self::FUNC_REMOVE_SUBSCRIBER,
            [
                self::ARG_DOMAIN => $this->domain,
                self::ARG_NAME => $mailingList->getLabel(),
                self::ARG_EMAIL => $email
            ]
        );
    }

    // -- Base functions to query the API
    private function get($function, $params)
    {
        if (isset($this->api)) {
            $url = $this->bindParameters($params, self::GET_COMMANDS[$function]);
            if (!isset($url)) {
                return false;
            }
            return $this->api->get($url);
        }
        return false;
    }

    private function put($function, $params)
    {
        if (isset($this->api)) {
            $url = $this->bindParameters($params, self::PUT_COMMANDS[$function]);
            if (!isset($url)) {
                return false;
            }
            return $this->api->put($url, $params);
        }
        return false;
    }

    private function post($function, $params)
    {
        if (isset($this->api)) {
            $url = $this->bindParameters($params, self::POST_COMMANDS[$function]);
            if (!isset($url)) {
                return false;
            }
            return $this->api->post($url, $params);
        }
        return false;
    }

    private function delete($function, $params)
    {
        if (isset($this->api)) {
            $url = $this->bindParameters($params, self::DELETE_COMMANDS[$function]);
            if (!isset($url)) {
                return false;
            }
            return $this->api->delete($url);
        }
        return false;
    }


    // -- Utilities
    private function bindParameters(&$params, $url)
    {
        $paramKeys = $this->getParametersFromURL($url);
        $bound = $url;
        foreach ($paramKeys as $paramKey) {
            if (array_key_exists($paramKey, $params)) {
                $bound = str_replace($paramKey, $params[$paramKey], $bound);
                unset($params[$paramKey]);
            } else {
                $bound = null;
                break;
            }
        }
        if (isset($bound) && strpos('{', $bound) !== false) {
            $bound = null;
        }
        return $bound;
    }

    private function getParametersFromURL($url)
    {
        $matches = [];
        preg_match_all('/\{[^,}]\}/g', $url, $matches, PREG_PATTERN_ORDER);
        return $matches[0];
    }

}