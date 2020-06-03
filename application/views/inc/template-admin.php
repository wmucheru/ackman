
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo isset($page_title) ? $page_title : ''; ?></title>
<meta name="description" content=""/>
<meta name="author" content=""/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<?php
    echo link_tag('favicon.png', 'shortcut icon', 'image/png');

    $styles = array(
        'assets/css/bootstrap.min.css',
        'assets/css/ionicons.min.css',
        'https://fonts.googleapis.com/css?family=Lato:400,900&display=swap',
        'assets/plugins/leaflet/leaflet.css',
        'assets/plugins/datatables/datatables.min.css',
        'assets/css/style.css?t='.date('YmdH')
    );

    foreach($styles as $stl){
        echo link_tag($stl);
    }
?>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    <script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
    <script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
<![endif]-->
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
</head>
<body class="admin-bd <?php echo isset($body_class) ? $body_class : ''; ?>">
    <div class="clearfix wrapper">
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" 
                        data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo site_url('admin/dashboard') ?>">
                        <?php echo img('assets/img/site-logo.png', '', 'class="img-responsive"'); ?>
                    </a>
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
                        <?php 
                            $menu = array(
                                array('url'=>'admin/dashboard', 'title'=>'Dashboard'),
                                array('url'=>'admin/users', 'title'=>'Users')
                            );

                            foreach($menu as $m){
                                $m = (object) $m;
                                $active = uri_string() == $m->url ? 'active' : '';

                                echo '<li class="'.$active.'">';
                                echo anchor($m->url, $m->title);
                                echo '</li>';
                            }
                        ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php 
                                    # $user = $this->auth_model->get_user_data();
                                    # var_dump($user);

                                    echo isset($user->name) ? $user->name : 'Default'; 
                                    
                                ?> <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo site_url('logout'); ?>">Log Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="page-wrapper clearfix container">
            <?php 
                $this->load->view($page_content);
            ?>
        </div>
    </div>
    <footer>
        <div class="container clearfix">
            <p>&copy; <?php echo date('Y') .'. ' . $this->config->item('site_name'). '.'; ?></p>
        </div>
    </footer>
    <?php
        echo '<script>const siteURL = "'. site_url() .'"</script>';

        if($this->site_model->isLocalhost()){
            $this->output->enable_profiler(TRUE);
        }
        
        $scripts = array(
            'assets/js/bootstrap.min.js',
            'assets/plugins/bxslider/jquery.bxslider.min.js',
            
            # Datatables
            'assets/plugins/datatables/datatables.min.js',
            'assets/js/custom.js'
        );
        
        foreach($scripts as $script){
            echo '<script src="' . base_url($script) . '"></script>';
        }
    ?>
</body>
</html>