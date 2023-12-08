<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        *{
            background-color: #0082c8;
        }
        body {
            display: flex;
            flex-direction: column;
            /* background-color: white; */
            font-family: Arial, Helvetica, sans-serif; 
            height: 500px;
            width: 400px;
            margin: auto;
            /* text-align: center; */
            margin-top: 70px;
            background-color: white;
        }
        a {
            background-color: white
        }
        button {
            background-color: skyblue;
            /* color: white; */
            padding: 14px 20px;
            margin: 8px 0;
            border: 3px solid #f1f1f1;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            opacity: 0.8;
        }
    </style>
</head>

<html>
    <body>
        <h2 style="text-align: center; background-color: white;">Doctor list</h2>
        <?php
            while($rows = mysqli_fetch_array($data['doctors'])) {
        ?>
            <a href="index.php?page=calendar/render/<?php echo$rows['id'];?>"><button type="submit" ><?php echo $rows['name'];?></button></a>
        <?php
            }
        ?>
    </body>
</html>