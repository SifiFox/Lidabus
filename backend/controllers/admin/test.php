<?php
session_start();
?>

<section>
    <div class="container">
        <?php
//            include "promocodeAdminController.php";
//            include "../user/promocodeController.php";
//            include "../auto/autoController.php";
//            include "driversPanelController.php";
//            include "../route/routeController.php";
//            include "../promocode/promocodeController.php";
            include "../order/orderController.php";

//            createPromocode();
//            setPromocode();
//            getAutosTable();
//            getDriversTable();
//        acceptRouteByDriver();
            userOrderRoute();

//        $promocodeString = $_POST['promocodeString'];
//        getPromocodeByString($promocodeString);

//        $autoID = $_POST['autoID'];
//        getAutoSeatsNumberByID($autoID);
//        getOccupiedPlacesNumberByAutoID($autoID);
        ?>
    </div>
</section>