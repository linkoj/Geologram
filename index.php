<?php
/*
This project was a failure because Facebook and Instagram have block off access to certain functionallites without the request/permission of public access
*/
?>


<?php
if (!empty($_GET['filter'])) {
    /**
     * Here we build the url we'll be using to access the google maps api
     */
    $maps_url = 'https://' .
        'maps.googleapis.com/' .
        'maps/api/geocode/json' .
        '?address=' . urlencode($_GET['filter']);
    $maps_json = file_get_contents($maps_url);
    $maps_array = json_decode($maps_json, true);
    $lat = $maps_array['results'][0]['geometry']['location']['lat'];
    $lng = $maps_array['results'][0]['geometry']['location']['lng'];
    /**
     * Time to make our Instagram api request. We'll build the url using the
     * coordinate values returned by the google maps api
     */
    $url = 'https://' .
        'api.instagram.com/v1/users/self/media/recent/?access_token=189493719.660268e.6e23abf9a7bd45fa9b1632e414bbec72'
        /*
        '?lat=' . $lat .
        '&lng=' . $lng .
        '&client_id=660268e7272049e9a07692c22de6eb8e'
        */; //replace "CLIENT-ID"
    $json = file_get_contents($url);
    $array = json_decode($json, true);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>geogram</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="script.js"></script>
</head>
<body>
<form action="" method="get">
    <input type="text" name="filter"/>
    <button type="submit">Submit</button>
</form>
<br/>
<div id="results" data-url="<?php if (!empty($url)) echo $url ?>">
    <?php
    if (!empty($array)) {
        foreach ($array['data'] as $key => $item) {
            echo '<img id="' . $item['id'] . '" src="' . $item['images']['standard_resolution']['url'] . '" alt=""/><br/>';
        }
    }
    ?>
</div>
</body>
</html>