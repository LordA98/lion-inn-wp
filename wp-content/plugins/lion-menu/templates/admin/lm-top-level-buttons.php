<div class="row">
    <!-- Save Button in Admin Page - to Save Menu Ranking -->
    <form action="#" method="POST" class="menu-form mx-3">
        <input type="hidden" name="menu_item_rankings" />
        <input class="btn btn-success" type="submit" value="Save Order" />
    </form>

    <div class="dropdown">
        <button class="btn btn-lion-purple dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Change Menu 
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            
            <?php
              
                foreach($menus as $menu) {

                    echo "<a class='dropdown-item' href='admin.php?page=lm-menu-edit-subpage&menu_id=$menu->id'>$menu->name</a>";

                }

            ?>

        </div>

    </div>

</div>

<br/>