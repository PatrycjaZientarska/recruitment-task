<link rel="stylesheet" href="../assets/css/styles.css">

<?php
$users = json_decode(file_get_contents('../dataset/users.json')); 

// Usunięcie rekordu 
if (isset($_POST['delete'])) {
    $idToDelete = $_POST['delete'];

    foreach ($users as $key => $user) {
        if ($user->id == $idToDelete) {
            array_splice($users, $key, 1);
            $usersArray = json_decode(json_encode($users), true);
            file_put_contents('../dataset/users.json', json_encode($usersArray));
            header('Location: main.php');
            exit;
        }
    }
}

// Dodanie nowego użytkownika
if(isset($_POST['submit'])){
    $new_user=array(
        "id" => count($users)+1,
        "name" => $_POST['name'],
        "username" => $_POST['username'],
        "email" => $_POST['email'],
        "address" => array(
            "street" => $_POST['address']['street'],
            "suite" => $_POST['address']['suite'],
            "city" => $_POST['address']['city'],
            "zipcode" => $_POST['address']['zipcode'],
            "geo" => array(
                "lat" => $_POST['address']['geo']['lat'],
                "lng" => $_POST['address']['geo']['lng'],
            ),
        ),
        "phone" => $_POST['phone'],
        "website" => $_POST['website'],
        "company" => array(
            "name" => $_POST['company']['name'],
            "catchPhrase" => $_POST['company']['catchPhrase'],
            "bs" => $_POST['company']['bs']
        ),
    );

    if(filesize("../dataset/users.json") == 0){
        $first_record = array($new_user);
        $data_to_save = $first_record;
    }
    else{
        $old_records = json_decode(file_get_contents("../dataset/users.json"));
        array_push($old_records, $new_user);
        $data_to_save = $old_records;
        $users = json_decode(file_get_contents('../dataset/users.json')); 
        header('Location: main.php');
    }
}
?>

<div id="container">
    <table id="users-table">
        <tr class="header">
            <td><p>Name</p></td>
            <td><p>Username</p></td>
            <td><p>Email</p></td>
            <td><p>Address</p></td>
            <td><p>Phone</p></td>
            <td><p>Company</p></td>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td>
                <p><?php echo $user->name ?></p>
            </td>
            <td>
                <p><?php echo $user->username ?></p>
            </td>
            <td>
                <p class="email">
                    <a href="mailto='<?php echo $user->email ?>'">
                        <?php echo $user->email ?>
                    </a>
                </p>
            </td>
            <td>
                <p><?php echo $user->address->street ?></p>
                <p><?php echo $user->address->zipcode ?></p>
                <p><?php echo $user->address->city ?></p>
            </td>
            <td>
                <p><?php echo $user->phone?></p>
            </td>
            <td>
                <p><?php echo $user->company->name?></p>
            </td>
            <td>
                <form id="buttons" method="post">
                    <input type="hidden" name="delete" value="<?php echo $user->id; ?>">
                    <button type="submit">Usuń</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <form id="new_user_form" action="" method="post">
            <label class="header">Formularz</label>
            
            <div id="form-container">
                <div class="left_column">
                    <p>
                        <label>Name*</label><br/>
                        <input type="text" name="name" value="" required>
                    </p>
                    <p>
                        <label>E-mail*</label><br/>
                        <input type="text" name="email" value="" required>
                    </p>
                    <p>
                        <label>Street*</label><br/>
                        <input type="text" name="address[street]" value="" required>
                    </p>       
                    <p>
                        <label>Zipcode*</label><br/>
                        <input type="text" name="address[zipcode]" value="" required>
                    </p>
                    <p>
                        <label>Phone number*</label><br/>
                        <input type="text" name="phone" value="" required>
                    </p>
                    <p>
                        <label>Company name*</label><br/>
                        <input type="text" name="company[name]" value="" required>
                    </p>
                    <p>
                        <label>Bs</label><br/>
                        <input type="text" name="company[bs]" value="">
                    </p>
                </div>

                <div class="left_column">
                    <p>
                        <label>Username*</label><br/>
                        <input type="text" name="username" value="" required>
                    </p>
                    <p>
                        <label>City*</label><br/>
                        <input type="text" name="address[city]" value="" required>
                    </p>
                    <p>
                        <label>Suite</label><br/>
                        <input type="text" name="address[suite]" value="">
                    </p>

                    <p id="geo_loc">
                        <label>Geo location</label>
                        <input id="geo_loc_1" type="text" name="address[geo][lat]" value="">
                        <input id="geo_loc_2" type="text" name="address[geo][lng]" value="">
                    </p>
                    <p>
                        <label>Website</label><br/>
                        <input type="text" name="website" value="">
                    </p>
                    <p>
                        <label>Catch phrase</label><br/>
                        <input type="text" name="company[catchPhrase]" value="">
                    </p>
                </div>
            </div>
            <p>
                <button type="submit" name="submit">Wyślij</button>
            </p>
    </form>
</div>
