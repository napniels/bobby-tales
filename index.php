<?php
$name = "";
$character = "";
$email = "";
$birth_year = 1969;
$validation_error = "";
$existing_users = ["admin", "guest"];
$options = ["options" => ["min_range" => 1940, "max_range" => date("Y")]];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   Name validation
    $raw_name = trim(htmlspecialchars($_POST["name"]));

    if(!in_array($raw_name, $existing_users)){
        if(ctype_upper($raw_name[0])){
            $validation_error .= "Name should start with a lowercase. <br>";
            $name = strtolower($raw_name);
        } else {
            $name = $raw_name;
        }
    } else {
        $validation_error .= "This name is taken. <br>";
    }

//   Character validation
    $raw_character = $_POST["character"];

    if(in_array($raw_character, ['Wizard', 'Mage', 'Orc'])){
        $character = $raw_character;
    } else {
        $validate_error .= "You must pick a wizard, mage, or orc. <br>";
    }

//    Email validation
    $raw_email = $_POST["email"];

    if(filter_var($raw_email, FILTER_VALIDATE_EMAIL)){
        $email = $raw_email;
    } else {
        $validation_error .= "Invalid email. <br>";
    }

//    Age validation
    $raw_birth_year = $_POST["birth_year"];

    if(filter_var($raw_birth_year, FILTER_VALIDATE_INT, $options)){
        if($character === 'Wizard' && $raw_birth_year % 4 !== 0){
            $validation_error .= "Wizards have to be born on a leap year. <br>";
            $character = "";
        } else {
            $birth_year = $raw_birth_year;
        }
    } else {
        $validation_error .= "That can't be your birth year. <br>";
    }
}
?>


<h1>Create your profile</h1>
<form method="post" action="">
    <p>
        Select a name: <input type="text" name="name" value="<?php echo $name;?>" >
    </p>
    <p>
        Select a character:
        <input type="radio" name="character" value="Wizard" <?php echo ($character=='wizard')?'checked':'' ?>> Wizard
        <input type="radio" name="character" value="Mage" <?php echo ($character=='mage')?'checked':'' ?>> Mage
        <input type="radio" name="character" value="Orc" <?php echo ($character=='orc')?'checked':'' ?>> Orc
    </p>
    <p>
        Enter an email:
        <input type="text" name="email" value="<?php echo $email;?>" >
    </p>
    <p>
        Enter your birth year:
        <input type="text" name="birth_year" value="<?php echo $birth_year;?>">
    </p>
    <p>
        <span style="color:red;"><?= $validation_error;?></span>
    </p>
    <input type="submit" value="Submit">
</form>

<h2>Preview:</h2>
<p>
    Name: <?=$name;?>
</p>
<p>
    Character Type: <?=$character;?>
</p>
<p>
    Email: <?=$email;?>
</p>
<p>
    Age: <?=date("Y")-$birth_year;?>
</p>