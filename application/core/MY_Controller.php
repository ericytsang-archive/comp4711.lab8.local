<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2013, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

    protected $data = array();      // parameters for view components
    protected $id;                  // identifier for our content

    /**
     * Constructor.
     * Establish view parameters & load common helpers
     */

    function __construct() {
        parent::__construct();
        $this->data = array();
        $this->data['title'] = 'Top Secret Government Site';    // our default title
        $this->errors = array();
        $this->data['pageTitle'] = 'welcome';   // our default page
    }

    /**
     * Render this page
     */
    function render() {
        $this->data['menubar'] = $this->parser->parse('_menubar', $this->makemenu(),true);
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

        // finally, build the browser page!
        $this->data['data'] = &$this->data;
        $this->parser->parse('_template', $this->data);
    }

    function restrict($roleNeeded = null)
    {
        $userRole = $this->session->userdata('userRole');
        if ($roleNeeded != null)
        {
            if (is_array($roleNeeded))
            {
                if (!in_array($userRole, $roleNeeded))
                {
                    redirect('/');
                    return;
                }
            }
            else if ($userRole != $roleNeeded)
            {
                redirect('/');
                return;
            }
        }
    }

    function get_user_role()
    {
        return ($this->session->userdata('userRole')) ?
            $this->session->userdata('userRole') : ROLE_VISITOR;
    }

    function get_user_name()
    {
        return ($this->session->userdata('userName')) ?
            $this->session->userdata('userName') : 'Visitor';
    }

    function makemenu() {
        // get role & name from session
        $userRole = $this->get_user_role();
        $userName = $this->get_user_name();

        // make array, with menu choices
        $menuChoices = array();

        // add link to alpha for everybody
        if(in_array($userRole,array(ROLE_USER,ROLE_ADMIN,ROLE_VISITOR)))
        {
            $menuChoices[] = array('name' => 'Alpha', 'link' => '/alpha');
        }

        // if user, add menu choice for beta and logout
        if(in_array($userRole,array(ROLE_USER,ROLE_ADMIN)))
        {
            $menuChoices[] = array('name' => 'Beta', 'link' => '/beta');
        }

        // if admin, add menu choices for beta, gamma and logout
        if(in_array($userRole,array(ROLE_ADMIN)))
        {
            $menuChoices[] = array('name' => 'Gamma', 'link' => '/gamma');
        }

        // if not logged in, add menu choice to login; logout button otherwise
        if(in_array($userRole,array(ROLE_USER,ROLE_ADMIN)))
        {
            $menuChoices[] = array('name' => 'Logout', 'link' => 'auth/logout');
        }
        else
        {
            $menuChoices[] = array('name' => 'Login', 'link' => 'auth');
        }

        // return the choices array
        return array('menudata'=>$menuChoices, 'username'=>'Hello, '.$userName);
    }
}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */
