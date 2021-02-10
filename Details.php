<?php
//Necessary includes
include("Common/Header.php");
include ("Common/Functions.php");
//Get restaurant by ID
$restId = (int)$_GET["id"];
//fetch data from XML File
$restaurant = simplexml_load_file("RestaurantReview.xml");

$j = 0;
//rating range (1 - 5)
$aRating = array(1, 2, 3, 4, 5);
//Initialize Array of allowed provinces
$provinces = array('ON', 'QC', 'BC', 'ALBT', 'SK', 'MB', 'NL', 'PEI', 'NB', 'NS', 'NT', 'NV', 'YK') ;
//Array of errors
$errorArray = array();


if(isset($_POST['btnSave']))
{
    sleep(1);
    //Extract all Post variables
    extract($_POST);

    //Basic Validations
    $errorPostalCode = ValidatePostalCode($postalCode);
    if(!empty($errorPostalCode))
    {
        $errorArray["postalCodeError"] = $errorPostalCode;
    }
    $errorRestName = ValidateRestName($restName);
    if(!empty($errorRestName))
    {
        $errorArray["errorRestName"] = $errorRestName;
    }

    $errorCity = ValidateCity($city);
    if(!empty($errorCity))
    {
        $errorArray["errorCity"] = $errorCity;
    }

    $errorStreet = ValidateStreetName($streetAddress);
    if(!empty($errorStreet))
    {
        $errorArray["errorStreetName"] = $errorStreet;
    }


    //If there are no errors, XML file will be updated
    if(empty($errorArray))
    {
        $restaurant->restaurant[$restId]->name = $restName;
        $restaurant->restaurant[$restId]->address->street = $streetAddress;
        $restaurant->restaurant[$restId]->address->city = $city;
        foreach ($restaurant->restaurant[$restId]->address->province as $node){
            $node[0] = $province;
        }
        $restaurant->restaurant[$restId]->address->postal_code = $postalCode;
        $restaurant->restaurant[$restId]->reviews->review->rating = $rating;
        $restaurant->restaurant[$restId]->reviews->review->summary = $summary;
        $restaurant->asXML('RestaurantReview.xml');
        $flushMessage = "File was successfully updated!";
    }
}


?>
<div class="container" style="padding: 15px; margin:auto">
    <form method="post" name="updateRest">
                <div class="form-group row" style="margin-top: 30px;">
                    <label class="col-sm-2 col-form-label" for="restName" style="padding: 5px">Restaurant Name:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" style="margin-bottom: 10px;" name="restName" value="<?php echo $restaurant->restaurant[$restId]->name?>"\>
                        <?php if(!empty($errorArray["errorRestName"])):?>
                            <small class="alert-danger" style="padding: 5px; border-radius: 5px">
                                <?php print($errorArray["errorRestName"])?>
                            </small>
                        <?php endif;?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="streetAddress" style="padding: 5px">Street Address:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control " style="margin-bottom: 10px;" name="streetAddress" value="<?php echo $restaurant->restaurant[$restId]->address->street?>"\>
                        <?php if(!empty($errorArray["errorStreetName"])):?>
                            <small class="alert-danger" style="padding: 5px; border-radius: 5px">
                                <?php print($errorArray["errorStreetName"])?>
                            </small>
                        <?php endif;?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="city" style="padding: 5px">City:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control " style="margin-bottom: 10px;" name="city" value="<?php echo $restaurant->restaurant[$restId]->address->city?>"\>
                        <?php if(!empty($errorArray["errorCity"])):?>
                            <small class="alert-danger" style="padding: 5px; border-radius: 5px">
                                <?php print($errorArray["errorCity"])?>
                            </small>
                        <?php endif;?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="province" style="padding: 5px">Province:</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="province" style="margin-bottom: 10px;">
                            <?php foreach ($provinces as $p):?>
                                <?php if($p == $restaurant->restaurant[$restId]->address->province):?>
                                    <option selected value="<?php  echo $p?>"><?php echo $p?></option>
                                <?php else:?>
                                    <option value="<?php echo $p?>"><?php echo $p?></option>
                                <?php endif;?>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="postalCode" style="padding: 5px">Postal Code:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" style="margin-bottom:10px " name="postalCode" value="<?php echo $restaurant->restaurant[$restId]->address->postal_code?>"\>
                        <?php if(!empty($errorArray["postalCodeError"])):?>
                            <small class="alert-danger" style="padding: 5px; border-radius: 5px">
                                <?php print($errorArray["postalCodeError"])?>
                            </small>
                        <?php endif;?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="summary" style="padding: 5px">Summary:</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="summary" style="margin-bottom: 10px; min-height: 250px;" value="">
                            <?php echo $restaurant->restaurant[$restId]->reviews->review->summary?>
                        </textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="rating" style="padding: 5px">Rating:</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="rating" style="margin-bottom: 10px;">
                            <?php
                            foreach ($aRating as $val)
                            {
                                if ($val == $restaurant->restaurant[$restId]->reviews->review->rating)
                                {
                                    echo '<option selected value="' . $val . '">' . $val . '</option>';
                                }
                                else
                                    {
                                        echo '<option value="' . $val . '">' . $val . '</option>';
                                    }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <button type="submit" id="submitBtn" class="btn btn-primary" name="btnSave">Save Changes</button>
                </div>
    </form>
</div>

    <script>
        $('#submitBtn').on('click', function () {
            $(this).addClass("disabled");
            $(this).html('' +
                '<span class="spinner-grow spinner-grow-sm"></span> Saving...');
            setTimeout(function(){$(this).removeClass("disabled");}, 2000);
        })
    </script>


<?php include ("Common/Footer.php")?>