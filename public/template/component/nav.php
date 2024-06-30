<?php
$navigation = $navigation ?? [];
?>
<nav>
    <ul>
    <?php foreach ($navigation as $name => $link) {?>
        <li>
            <a href="" hx-get="<?=$link?>"
                hx-push-url="true"
               hx-target="#content"><?=$name?></a>
        </li>
    <?php }?>
    </ul>
</nav>
