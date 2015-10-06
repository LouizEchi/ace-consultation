<!DOCTYPE html>
<html>
    <head>
        <title>Student Consultation <?php isset($page_title) ? ' - ' . $page_title : '' ?></title>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- Import materialize.css -->
        <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/materialize/css/materialize.css" media="screen, projection"/>
        <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/global.css"/>
        <link rel="shortcut icon" href="http://sstatic.net/stackoverflow/img/favicon.ico">
        
        <?php
            if (isset($a_css_sheets)) {
                foreach($a_css_sheets as $s_css_sheet) {
                    echo "\t" . '<link rel="stylesheet" href="' . $s_css_sheet .  '">' . "\r\n";
                }
            }
        ?>

        <script type="text/javascript" src="<?=base_url()?>assets/js/jquery-2.1.4.js"></script>
        <script type="text/javascript" src="<?=base_url()?>assets/js/materialize/js/materialize.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>assets/js/global.js"></script>

        <?php
            if (isset($a_js_scripts)) {
                foreach ($a_js_scripts as $s_js) {
                    echo "\t" . '<script type="text/javascript" src="' . $s_js . '"></script>' . "\r\n";
                }
            }
        ?>
        <!-- Let browser know website is optimized for mobile -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
    </head>
    <body>
        <input type="hidden" name="page_title" value="<?= isset($page_title) ? ' - ' . $page_title : ''?>">
        <input type="hidden" name="menu_id" value="<?= isset($menu_id) ? $menu_id : ''?>">
        <?php
            if(isset($s_page_type))
            {
                if($s_page_type == 'admin')
                {

                    echo'<nav class="transparent">' .
                            '<div class="nav-wrapper transparent">' .
                                '<ul class="right">' . 
                                    '<li><a class="waves-effect waves-teal white-text text-lighten-1" href="'. base_url() .'login/logout">Logout</a></li>' .
                                '</ul>' .
                                '<ul id="nav-mobile" class="left hide-on-med-and-down">' .
                                    '<li id="menu_home"><a class="waves-effect waves-teal white-text text-lighten-1" href="'. base_url() .'admin"> <i class="material-icons left">home</i> Home </a></li>' .
                                    '<li id="menu_records"><a  class="dropdown-button" href="#" data-activates="records"> <i class="material-icons left">book</i> Records </a></li>' .
                                '</ul>'.
                            '</div>' .
                        '</nav>' .
                        '<ul id="records" class="dropdown-content transparent">' .
                            '<li id="menu_student_records" ><a class="waves-effect waves-teal white-text text-lighten-1" href="'. base_url() .'admin/student_logs">Student</a></li>' .
                            '<li id="menu_teacher_records"><a class="waves-effect waves-teal white-text text-lighten-1" href="'. base_url() .'admin/teacher_logs">Teacher</a></li>' .
                        '</ul>';
                }
            }
        ?>