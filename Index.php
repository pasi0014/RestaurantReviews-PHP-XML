<?php
session_start();
include ('Common/Header.php');


$restaurant = simplexml_load_file("RestaurantReview.xml");

$i = 0;
?>

<div class="container">
    <h1 class="display-4 mt-3 mb-5">Restaurant Overview</h1>
    <form action="Details.php" method="get">
    <div class="form-group form-inline">
        <label for="restSelect" class="label font-weight-bold mr-3">Restaurant:</label>
        <select name="restSelect" class="form-control w-50" id="restSelect" >
            <?php foreach ($restaurant as $key=>$value):?>
                <option value="<?php echo $i++?>"><?php echo $value[0]->name?></option>
            <?php endforeach?>
        </select>
    </div>
    </form>
</div>

    <script type="text/javascript">
        $("body").on('change', '#restSelect', function(){
            let selectedValue = $(this).val();

            $.ajax({
                url:"index.php",
                type:"POST",
                data: {option : selectedValue},
                success: function(){
                    window.location.href = "Details.php?id=" + selectedValue;
                }
            });
        });
    </script>


<?php include ('Common/Footer.php');?>