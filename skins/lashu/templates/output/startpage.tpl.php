<?php $this->displayHead(); ?>
    <body <?php echo $this->getBackgroundStyle()?>>
        <?php $this->displayHeader(); ?>

        <?php
        global $_CFG;
        global $web;

        $x = 0;
        $initialActiveCategory = $web->active_category;

        $SQL_str = "SELECT * FROM wbg_tree_categories WHERE parent_id=".WBG::mirror(3)." AND active=1 ORDER BY sort_id";
        $sql_res = mysql_query($SQL_str);

        while ($arr = mysql_fetch_assoc($sql_res))
        {
            if ($arr['active']) {
                $web->active_category = $arr['id'];
                $web->active_tree[1] = $arr['id'];
                echo '<div id="'.str_replace(array('eng/', '/'), '', $arr['dir']).'" class="page'.($x++ % 2 ? '-alternate' : '').'">
                    <div class="container">';
                
                $modName = mysql_result(mysql_query("SELECT title FROM wbg_modules WHERE id=".$arr['output_module']), 0, 0);
                WBG::module($modName);

                echo '</div></div>';
            }
        }
        $web->active_category = $initialActiveCategory;
        ?>
        <?php $this->displayFooter(); ?>
        <?php $this->includeTemplate('parts/footer_script'); ?>
    </body>
</html>