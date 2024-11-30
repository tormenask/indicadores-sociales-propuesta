<?php
function resultBlock($errors) {
    if (count($errors) > 0) {
        echo " <div class='alert alert-danger alert-dismissable'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>";
        
        foreach ($errors as $err) {
            echo "<li>" . $err . "</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
}
function resultConfirm($msgConfirm) {
    if (count($msgConfirm) > 0) {
        echo " <div class='alert alert-success alert-dismissable'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>";
        
        foreach ($msgConfirm as $msg) {
            echo "<li>" . $msg . "</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
    
}
function resultWarning($msgAlert) {
    if (count($msgAlert) > 0) {
        echo " <div class='alert alert-dismissable' style='background-color:#fff3cd; color:#93751c;'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>";
        
        foreach ($msgAlert as $msg) {
            echo "<li>" . $msg . "</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
    
}
