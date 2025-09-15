<?php
include('includes/config.php');

$marks = isset($_GET['marks']) ? intval($_GET['marks']) : 0;

$sql = "SELECT tblstudents.StudentName, tblstudents.RollId, tblclasses.ClassName, 
        tblsubjects.SubjectName, tblresult.marks
        FROM tblresult
        JOIN tblstudents ON tblresult.StudentId = tblstudents.StudentId
        JOIN tblclasses ON tblstudents.ClassId = tblclasses.id
        JOIN tblsubjects ON tblresult.SubjectId = tblsubjects.id
        WHERE tblresult.marks <= :marks
        ORDER BY tblstudents.StudentName ASC";

$query = $dbh->prepare($sql);
$query->bindParam(':marks', $marks, PDO::PARAM_INT);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() > 0){
    $cnt = 1;
    foreach($results as $row){
        echo "<tr class='fail-row'>";
        echo "<td>".htmlentities($cnt)."</td>";
        echo "<td>".htmlentities($row->StudentName)."</td>";
        echo "<td>".htmlentities($row->RollId)."</td>";
        echo "<td>".htmlentities($row->ClassName)."</td>";
        echo "<td>".htmlentities($row->SubjectName)."</td>";
        echo "<td style='color:red;font-weight:bold;'>".htmlentities($row->marks)."</td>";
        echo "</tr>";
        $cnt++;
    }
} else {
    echo "<tr><td colspan='6' style='text-align:center;color:gray;'>No students found at or below this mark</td></tr>";
}
