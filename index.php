<?php

// Vérification de l'upload de fichier
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Vérification de la taille du fichier
    if ($_FILES["photo"]["size"] > 1048576) {
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }

    // Vérification du type de fichier
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "webp") {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG, GIF et WEBP sont autorisés.";
        $uploadOk = 0;
    }

    // Vérification du nom de fichier
    if (file_exists($target_file)) {
        echo "Désolé, le fichier existe déjà.";
        $uploadOk = 0;
    }

    // Déplacement du fichier temporaire vers son emplacement final
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            echo "Le fichier " . basename($_FILES["photo"]["name"]) . " a été téléchargé.";
        } else {
            echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homer Simpson Identity</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Photo de profil d'Homer</h2>

        <?php
        if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['age'])) {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $age = $_POST['age'];
            $photo = "uploads/" . basename($_FILES["photo"]["name"]);
        ?>

            <img src="<?= $photo ?>" alt="Photo de profil d'Homer">
            <p>Nom : <?= $nom ?></p>
            <p>Prénom : <?= $prenom ?></p>
            <p>Âge : <?= $age ?></p>
            <button class="delete-button" onclick="deletePhoto()">Supprimer la photo</button>
            <script>
                function deletePhoto() {
                    if (confirm("Voulez-vous vraiment supprimer la photo ?")) {
                        window.location.href = "delete.php?file=<?= $photo ?>";
                    }
                }
            </script>
        <?php
        } else {
        ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="photo">Photo:</label>
                    <input type="file" name="photo" id="photo">
                    <label for="photo" class="custom-file-upload">Choisir une photo</label>
                </div>
                <div class="form-group">
                    <label for="nom">Nom:</label>
                    <input type="text" name="nom" id="nom">
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom:</label>
                    <input type="text" name="prenom" id="prenom">
                </div>
                <div class="form-group">
                    <label for="age">Âge:</label>
                    <input type="number" name="age" id="age">
                </div>
                <button type="submit">Envoyer</button>
            </form>
        <?php
        }
        ?>
    </div>
</body>

</html>