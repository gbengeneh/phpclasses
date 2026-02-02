<!DOCTYPE html>
<html> 
<head> 
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body> 
<h3>Chess Board using Nested For Loop</h3>
<table width="570px" cellspacing="0px" cellpadding="0px" border="1px">
<!-- cell 270px wide (8 columns x 60px) -->
<?php
// Outer loop for rows
for($row=1; $row<=8; $row++)
{
    echo "<tr>"; // Start a new table row
    
    // Inner loop for columns
    for($col=1; $col<=8; $col++)
    {
        // Calculate total sum of row and column indices
        $total = $row + $col;
        
        // Check if total is even or odd to determine cell color
        if($total % 2 == 0)
        {
            // If total is even, set cell background color to white
            echo "<td height=60px width=60px bgcolor=#FFFFFF></td>";
        }
        else
        {
            // If total is odd, set cell background color to black
            echo "<td height=60px width=60px bgcolor=#000000></td>";
        }
    }
    
    echo "</tr>"; // End the table row
}
?>
</table>
</body>
</html>
