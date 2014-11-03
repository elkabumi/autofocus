<?php

class MY_Session extends CI_Session{
/*
    function _serialize($data)
    {
        return json_encode($data);
    }
    
    function _unserialize($data)
    {
        return json_decode($data,true);
    }

*/
    public function sess_update()
    {
        /*if ( ! IS_AJAX)
        {
            
        }*/
		parent::sess_update();
    }

    function sess_destroy()
    {
        parent::sess_destroy();

        $this->userdata = array();
    }
}


#
