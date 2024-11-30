<?php

class LinkBack {

    public function linkControllerBack() {
        if (isset($_GET["action"])) {
            $links = $_GET["action"];
        } else {
            $links = "index";
        }
        $link = new LinkModelBack();
        $resp = $link->linksModelBack($links);
        include $resp;
    }

}
