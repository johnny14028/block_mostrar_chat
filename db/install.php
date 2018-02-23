<?php

function xmldb_block_chat_install()
{
    global $DB, $USER;
    //listamos los usuarios activos de la plataforma
    $users = $DB->get_records('user',['deleted'=>0,'suspended'=>0]);
    
    if(is_array($users) && count($users)>0){
        foreach($users as $index=>$objUser){
            $context_user = context_user::instance($objUser->id);
            $objBlockInstanceExist =  $DB->get_record('block_instances',['parentcontextid'=>$context_user->id], '*', IGNORE_MULTIPLE);
            //validamos si tiene un registro de usuario
            $objBlockInstance =  $DB->get_record('block_instances',['blockname'=>'chat','parentcontextid'=>$context_user->id]);
            if(!is_object($objBlockInstance)){
                //registramos el blocke
                $objBlockChatBean = new stdClass();
                $objBlockChatBean->blockname = 'chat';
                $objBlockChatBean->parentcontextid = $context_user->id;
                $objBlockChatBean->showinsubcontexts = 0;
                $objBlockChatBean->requiredbytheme = 0;
                $objBlockChatBean->pagetypepattern = 'my-index';
                $objBlockChatBean->subpagepattern = $objBlockInstanceExist->subpagepattern;
                $objBlockChatBean->defaultregion = 'side-pre';
                $objBlockChatBean->defaultweight = 5;
                $objBlockChatBean->configdata = '';
                $objBlockChatBean->timecreated = time();
                $objBlockChatBean->timemodified = time();
                $DB->insert_record('block_instances',$objBlockChatBean);
            }
        }
    }
    return true;    
}