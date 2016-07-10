<?php
/**
 * Template Name: Angular Template
 */
?>

<script type="text/javascript">
    var WPTemplateDir = "<?php bloginfo('template_directory') ?>";
    var WPHomeUrl = "<?php echo home_url('/') ?>";
</script>

<div class="container" ng-app="testApp">
    <div class="row">
        <div class="col-sm-12">
            <?php get_template_part('templates/page', 'header'); ?>

            <section>
                <div class="panel panel-default">
                    <div class="panel-body">

                        <ul class="nav nav-pills">
                            <li active-link="active">
                                <a href="#/" ng-click="selected = 'home'">Home</a>
                            </li>
                            <li active-link="active">
                                <a href="#/blog" ng-click="selected = 'blog'">Blog</a>
                            </li>
                            <li active-link="active">
                                <a href="#/authors" ng-click="selected = 'authors'">Posts by specific Author</a>
                            </li>
                            <li active-link="active">
                                <a href="#/all-post-ids" ng-click="selected = 'all-post-ids'">Display all Post ID's</a>
                            </li>
                        </ul>

                    </div>
                </div>

                <!-- templates are rendered here -->
                <div ng-view></div>

            </section>

        </div>
    </div>
</div>
<?php the_content(); ?>
<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>