<?php
    $error = "";
    $weather = "";
    if(array_key_exists('city' ,$_GET)){
        $city = str_replace(' ', '' ,$_GET['city']);
        $f_headers = @get_headers("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");

        if($f_headers[0] == "HTTP/ 1.1 404 Not Found"){
            $error = "That city could not be found";
        }else{
            $file_content = @file_get_contents("https://www.weather-forecast.com/locations/" . $city . "/forecasts/latest");
            $firstPage = explode('Weather Today</h2> (1&ndash;3 days)</div><p class="b-forecast__table-description-content"><span class="phrase">',$file_content);
            if(sizeof($firstPage)>1){
                $secondPage = explode("</span></p></td>" ,$firstPage[1]);
                if(sizeof($secondPage) >1){
                    $weather = $secondPage[0];
                }else{
                    $error = "That city could not be found";
                }
            }else{
                $error = "That city could not be found";
            }
        }// city is founded
    } else{
        $error = "That city could not be found";
    } //end of arry key exists


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MuzahidWeather-Scraper</title>
    <link rel="stylesheet" href="General.css">
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

    <style>
        html {
            background: url(https://source.unsplash.com/1920x1080/?mountain,nature) no-repeat center center fixed;
            background-size: cover;
        }

        body {
            background: none;
        }

        label {
            color: white;
            text-shadow: 0px 0px 5px grey;
        }

        h1 {
            margin-top: 150px;
            margin-bottom: 20px;
            color: white;
            text-shadow: 0px 0px 5px grey;
        }

        form {
            width: 30%;
        }

        fieldset {
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 100%;
        }

        input {
            width: 200px;
            border-radius: 20px;
            
        }
        #weather{
            width: 50%;
            margin-top: 20px;
            margin-bottom: 10px;
        }

       
    </style>
</head>

<body>
    <div class="container-self bg-glass">
        <h1 class="text-center"> Get Weather Information</h1>
        <form>
            <fieldset class="form-group">
                <label class="text-center mb-2" for="weather">Enter the name of a city.</label>
                <input type="text" class="form-control" id="city" placeholder="Eg. London, Dhaka" name="city"
                 value ="<?php
                    if(array_key_exists('city', $_GET)){
                        echo $_GET['city'];
                    }
                 ?>">
                <button class="classic-btn" type="submit">Submit</button>
            </fieldset>
        </form>
        <div id="weather">
            <?php
            if(array_key_exists('city', $_GET)){
                if($weather){
                    echo  '<div class="alert alert-success" role="alert"><p>'. $weather . "</p></div>";
                }
                else if($error){
                    echo '<div class="alert alert-danger" role="alert"><p>'. $error . "</p></div>";
                }
            }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>