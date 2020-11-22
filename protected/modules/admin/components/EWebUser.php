<?php

class EWebUser extends CWebUser{
 
    protected $_model;

//    // Load user model.
    function loadUser()
    {
        if ( $this->_model === null ) {
                $this->_model = User::model()->findByPk( $this->id );
        }
        return $this->_model;
    }
    
    function isUserAllowed($priviledge_object)
    {
        if(Yii::app()->user->getId() != NULL)
        {
            $lec_id     = Lecturer::model()->getLecturerIdByUserId(Yii::app()->user->getId());
            $priviledge = LecturerPrivilege::model()->getIndividualPriviledge($priviledge_object,$lec_id);
            
            return $priviledge;
        }
    }
}
?>
