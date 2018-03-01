<?php

function xmldb_block_chat_install()
{
    global $DB, $USER;
    //listamos los usuarios activos de la plataforma
    $courses = $DB->get_records_sql("SELECT * FROM {course} WHERE category > 0");
//    
    if(is_array($courses) && count($courses)>0){
        foreach($courses as $index=>$objCourse){
            $context_course = context_course::instance($objCourse->id);
            $objBlockInstanceExist =  $DB->get_record('block_instances',['parentcontextid'=>$context_course->id], '*', IGNORE_MULTIPLE);
            //validamos si tiene un registro de usuario
            $objBlockInstance =  $DB->get_record('block_instances',['blockname'=>'chat','parentcontextid'=>$context_course->id]);
            if(!is_object($objBlockInstance)){
                //registramos el blocke
                $objBlockChatBean = new stdClass();
                $objBlockChatBean->blockname = 'chat';
                $objBlockChatBean->parentcontextid = $context_course->id;
                $objBlockChatBean->showinsubcontexts = 0;
                $objBlockChatBean->requiredbytheme = 0;
                $objBlockChatBean->pagetypepattern = 'course-view-*';
                $objBlockChatBean->subpagepattern = isset($objBlockInstanceExist->subpagepattern)?$objBlockInstanceExist->subpagepattern:NULL;
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