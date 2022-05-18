<!DOCTYPE html>
<html>
    <head>
        <title>Backend Rest</title>
    </head>
    <body>
        <?php
        $servername = '172.17.0.1:3306';
        $username = 'root';
        $password = 'my-secret-pw';
        $dbname = "mydb";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        
        if (!$conn)
        {
            die("Could not connect MySql Server");
        }

        $page = 0;
        $size = 20;
        $totalElements = 0;
        $query = "SELECT COUNT(employees.id) AS conteggio FROM employees";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $totalElements = $row["conteggio"];
        }

        $method = $_SERVER['REQUEST_METHOD'];

        switch($method){
            case 'GET':
                $page = $_GET["page"];
                $size = $_GET["size"];

                $limitA = $page * $size;
                $totalPages = ceil($totalElements / $size);

                $firstPage = "http://localhost:8080?page=" . $page . "&size=" . $size;
                $totPages = $totalPages - 1;
                $lastPage = "http://localhost:8080?page=" . "?page=" . $totPages . "&size=" . $size;

                $sql = "SELECT * FROM employees ORDER BY employees.id LIMIT ".$limitA.",".$size."";
                $result = mysqli_query($conn, $sql);
                if (mysqli_query($conn, $sql)){
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                        $array[] = $row;
                    }    
                }

                $employee = array(
                    "_embedded" => array(
                        "employees" => $array[]
                    )
                  );
              
                $last = $page - 1;
                $next = $page + 1;
            
                if($page == 0){
                    $tmp = array(
                    "first" => array("href" => $firstPage),
                    "last" => array("href" => $lastPage),
                    "next" => array("href" => "http://localhost:8080?page=" . "?page=" . $next . "&size=" . $size)
                    );
                }else if($page == $totPages){
                    $tmp = array(
                    "first" => array("href" => $firstPage),
                    "last" => array("href" => $lastPage),
                    "prev" => array("href" => "http://localhost:8080?page=" . "?page=" . $last . "&size=" . $size)
                    );
            
                }else if($page > 0 && $page<$totTmp){
                    $tmp = array(
                    "first" => array("href" => $firstPage),
                    "last" => array("href" => $lastPage),
                    "next" => array("href" => "http://localhost:8080?page=" . "?page=" . $next . "&size=" . $size),
                    "prev" => array("href" => "http://localhost:8080?page=" . "?page=" . $last . "&size=" . $size)
                    );
                }

                $tmpEmployee = array(
                    "size" => $size,
                    "total_Elements" => $totalElements,
                    "total_Pages" => $totalPages,
                    "number" => $page
                );

                $arrayEmployee = array(
                    $employee,
                    "_links" => $tmp,
                    "page" => $tmpEmployee
                  );
        
                $data = json_encode($arrayEmployee);
                echo $data;
            break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $sql = "INSERT INTO employees (id, birth_date, first_name, last_name, gender, hire_date)
                VALUES (".$mysqli->real_escape_string($data['id']).",
                ".$mysqli->real_escape_string($data['birth_date']).", 
                ".$mysqli->real_escape_string($data['first_name']).", 
                ".$mysqli->real_escape_string($data['last_name']).",
                ".$mysqli->real_escape_string($data['gender']).",
                ".$mysqli->real_escape_string($data['hire_date']).")";
                if (mysqli_query($conn, $sql)){
                    
                } 
                else 
                {
                    echo "Error: " . $sql . ":-" . mysqli_error($conn);
                }
            break;
            case 'PUT':
                $data = json_decode(file_get_contents('php://input'), true);

                $birth_date = $mysqli->real_escape_string($data['birth_date']);
                $first_name = $mysqli->real_escape_string($data['first_name']);
                $last_name = $mysqli->real_escape_string($data['last_name']);
                $gender = $mysqli->real_escape_string($data['gender']);
                $hire_date = $mysqli->real_escape_string($data['hire_date']);

                $sql = "UPDATE employees SET birth_date = $birth_date, 
                first_name = $first_name,
                last_name = $last_name,
                gender = $gender,
                hire_date = $hire_date
                WHERE employees.id = ".$mysqli->real_escape_string($data['id'])."";

                $result = mysqli_query($conn, $sql);
                if (mysqli_query($conn, $sql)){

                } 
                else 
                {
                    echo "Error: " . $sql . ":-" . mysqli_error($conn);
                }
            break;
            case 'DELETE':
                $id = $mysqli->real_escape_string($_GET["id"]);
                $sql = "DELETE FROM employees WHERE employees.id = ".$id."";
                $result = mysqli_query($conn, $sql);
                if (mysqli_query($conn, $sql)){

                } 
                else 
                {
                    echo "Error: " . $sql . ":-" . mysqli_error($conn);
                }
            break;
            default:
                echo "Errore!! Richiesta non valida.";
            break;
        }
        mysqli_close($conn);
        ?>
    </body>
</html>
