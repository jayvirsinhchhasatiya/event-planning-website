<?php
session_start();
// print_r($_SESSION);

if (!isset($_SESSION['client'])) {

    echo '<script>
        alert("Please login to continue");
        window.location.href = "login.php";
        </script>';
    // header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Planning</title>

    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- OWN CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- navbar -->
    <?php
    include 'navbar.php';
    ?>

    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae iste cumque quos, autem tempora esse laborum fugit dicta velit aperiam perspiciatis culpa illo exercitationem alias corrupti omnis eos quam nam consectetur? Deserunt eveniet vitae similique corrupti magnam sit excepturi commodi ducimus. Et voluptatem rerum maiores, non deserunt eos beatae saepe eaque aspernatur iusto! Quos aspernatur dolore veritatis, quidem at voluptas iste modi officia possimus consequuntur illum optio libero repellat, corporis, deserunt ab dolorum eveniet aliquid iusto dicta neque! Hic minima ratione doloribus dolores error, assumenda eius commodi expedita, animi at voluptatibus debitis, cupiditate pariatur quidem enim quis fugit quam quae corrupti. Consequuntur alias voluptatem eaque assumenda atque, repellat aspernatur saepe, incidunt quidem veniam pariatur repudiandae esse perspiciatis suscipit, beatae excepturi. Aut illo quisquam impedit autem ad, perspiciatis quidem unde earum et praesentium assumenda? Voluptate, exercitationem natus doloremque officia amet minima sint, voluptatum sed blanditiis, magnam veritatis ex distinctio ipsa esse obcaecati et reiciendis necessitatibus eius quis nobis. Est asperiores deleniti odit sequi repellendus optio ullam veniam cumque, quis officiis atque voluptatum ut eligendi adipisci animi eum explicabo quasi quaerat ratione fuga nostrum accusantium voluptatem praesentium! Quidem maxime quos dolorum, rerum laboriosam ab, mollitia repudiandae quia repellendus, consectetur saepe hic itaque. Voluptatem sed cupiditate, laudantium esse doloremque totam? Enim, voluptates sint voluptatum ipsam cumque, omnis minima nihil nisi ullam maiores nobis, similique corporis distinctio quae natus fugit? Ab nam pariatur voluptatibus. Suscipit sapiente doloremque minus, debitis ex pariatur temporibus mollitia vero qui! Dolorum deleniti earum, deserunt quod quae repellat mollitia harum vitae similique corporis numquam animi iusto, nisi libero et dolore odio ex autem iure, ullam neque quidem explicabo reiciendis possimus? Accusamus dignissimos deleniti, illo architecto eveniet vitae alias laborum voluptate iure, fugiat, pariatur hic! Placeat, est necessitatibus earum a omnis repellendus modi nemo nostrum. Voluptate nisi voluptates hic, accusantium ex laboriosam, ad sed, mollitia cupiditate corporis impedit. Fugiat aliquid dicta minima in obcaecati quia commodi mollitia dignissimos reiciendis, quaerat nihil consequatur, harum repellendus, cumque possimus rerum. Voluptas vel perferendis repudiandae dignissimos nemo dicta rem, saepe sed corporis? Tempore fuga, repellat explicabo officia enim molestias adipisci esse praesentium ea? Iure aspernatur animi veritatis est sunt culpa blanditiis? Ullam praesentium saepe sequi quasi delectus quo odit impedit dolore provident fugit reiciendis fuga non accusamus illo magnam amet minus voluptas, est illum. Maiores perspiciatis molestiae nemo. Reiciendis soluta odit, provident nesciunt porro suscipit, ut corrupti deleniti obcaecati unde laboriosam molestias! Non eum iusto alias, sapiente iure aliquid laborum maiores placeat sunt optio nam quae a fuga cum ab fugiat sint? Accusamus omnis minus magnam? Officia dolores minus aliquam dolore vitae, distinctio accusamus doloremque facilis esse corporis doloribus consectetur, iure blanditiis sed corrupti nihil quis saepe alias. Quae pariatur amet alias a tempora eos consectetur molestias accusantium, ducimus voluptate sit aperiam numquam, provident rerum ratione recusandae itaque dolore! Placeat ducimus, provident illo sit a eaque cupiditate maxime laboriosam minima possimus et libero impedit beatae recusandae praesentium unde fugiat. Quo quas facilis pariatur, atque, nihil natus doloremque numquam ducimus dolore sunt aliquam. Nostrum, quidem vitae vel asperiores laudantium vero dicta sint aspernatur facere ab rerum cupiditate dolores iure aliquam dignissimos voluptates doloribus ad tenetur a eveniet nulla sapiente totam veniam. Soluta aperiam, veritatis aliquid inventore quo dolores sed eius, esse, corporis tempora ad tenetur deleniti expedita numquam dolor laborum. Asperiores dolorum placeat reprehenderit voluptatum harum, laudantium labore? Explicabo voluptate rem, quasi ratione repellat minus officiis doloremque vel corporis libero quod eos excepturi deleniti ex quas in nobis, dicta cupiditate? Accusantium odit sequi neque soluta suscipit quod, eos officiis adipisci, voluptatem doloribus temporibus cum incidunt ad obcaecati blanditiis corporis! Perspiciatis iste aspernatur consequatur nam earum deserunt at soluta exercitationem voluptatibus aliquid ut nulla error tempora rerum officiis, adipisci necessitatibus mollitia sit facere impedit. Rerum, error sequi accusantium laborum impedit odio facilis nobis odit, iure tempore praesentium dolorum eaque debitis rem sapiente temporibus illo maxime dolorem est quod aliquam alias, commodi tenetur. Harum praesentium temporibus magnam dolore nostrum debitis consequuntur, consequatur repellendus, sunt provident, fugiat aperiam illo perspiciatis saepe accusamus voluptatum. Deleniti exercitationem dolor facere perspiciatis iste? Tenetur atque error exercitationem tempora sapiente suscipit facilis nam quasi asperiores sint sit possimus facere nesciunt deleniti sequi, optio omnis dolorem quod non, inventore saepe, architecto mollitia itaque! Saepe mollitia quidem reiciendis eos qui voluptatibus nam accusamus maiores natus provident aut vitae, adipisci animi ipsa corporis, tenetur alias rem quae iste! Quod quibusdam alias reprehenderit necessitatibus molestiae illum et temporibus, quas asperiores itaque iure voluptatum ratione laudantium, recusandae libero voluptate minima maxime doloremque. Minus nostrum voluptatibus quisquam nam debitis obcaecati, atque fugit quo dolores magni dolore harum aperiam ut earum? Dolorem, alias beatae ipsa explicabo quod porro, iste voluptates natus temporibus quia suscipit veritatis! Sit magni dolores doloribus rerum harum possimus, rem neque eveniet impedit. Reprehenderit nisi dolorem quos, praesentium alias, animi a quam ipsa incidunt ullam, laudantium aut recusandae impedit sunt debitis odio. Eius, quas nam veritatis unde, ex esse aliquam dolor sit sequi repudiandae fugit optio omnis accusantium dolores odio quo laudantium assumenda tempore tempora qui perferendis dolore. Qui ipsum ratione consectetur corrupti, eaque voluptas beatae dolore recusandae quod iusto quisquam, enim excepturi quas ea nobis tempora labore. Laboriosam perspiciatis, facilis saepe magnam dolorem, quibusdam sequi enim reprehenderit quasi asperiores dignissimos ipsam sapiente, voluptas debitis necessitatibus nisi aliquam repellendus doloremque? Ratione necessitatibus totam libero quisquam amet, atque consequuntur reiciendis quibusdam quaerat facere. Ad temporibus maxime quos sapiente, veritatis aspernatur incidunt ab, laboriosam facere dolorum itaque dignissimos ipsam autem perferendis aperiam facilis illum obcaecati quas amet? Totam nostrum magni tenetur dolores amet laudantium? Ipsam quibusdam tempora sint, dolorum reprehenderit voluptate repudiandae soluta odio harum id minima nobis! Hic esse repudiandae architecto voluptatem animi odit. Ipsa officia mollitia facilis, similique, architecto deleniti necessitatibus odit, voluptas ducimus a reprehenderit esse? Voluptas excepturi sint eum provident modi hic nulla placeat magnam iste dolores expedita, odit doloribus reprehenderit quis quo unde neque, adipisci commodi vitae vero velit, saepe rerum eveniet distinctio? Fugit sequi neque sapiente quaerat distinctio quibusdam aliquam enim culpa recusandae error! Doloremque eaque praesentium laboriosam, iste obcaecati similique molestiae laborum non.</p>

    <!-- section-9 footer-->
    <?php
    include 'footer.php';
    ?>

    <!-- JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"></script>
    <!-- own js -->
    <script src="index.js"></script>
</body>

</html>