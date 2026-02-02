<?php 
 $num1=$num2= $result= $error= "";
 $operation= "";

 //process form data when form is submitted
 if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['submit'])){
  $num1= isset($_POST['num1']) ? trim($_POST['num1']) : '';  
  $num2= isset($_POST['num2']) ? trim($_POST['num2']) : '';  
  $operation= isset($_POST['operation']) ? $_POST['operation'] : '';

    //validate inputs
     if(empty($num1) || empty($num2)){
        $error= "Both numbers are required.";
     }elseif(!is_numeric($num1) || !is_numeric($num2)){
        $error= "Please enter valid numbers.";
     }elseif(empty($operation)){
        $error= "Please select an operation.";
     }else{
        //Convert to float for calculation
        $num1= floatval($num1);
        $num2= floatval($num2);
// Perform calculation based on selected operation
        switch($operation){
            case '+':
                $result= $num1 + $num2;
                break;
            case '-':
                $result= $num1 - $num2;
                break;
            case '*':
                $result= $num1 * $num2;
                break;
            case '/':
                if($num2 == 0){
                    $error= "Division by zero is not allowed.";
                }else{
                    $result= $num1 / $num2;
                }
                break;
            case '%':
                if($num2 == 0){
                    $error= "Modulus by zero is not allowed.";
                }else{
                    $result= fmod($num1, $num2);
                }
                break;
            default:
                $error= "Invalid operation selected.";
        }
     }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Calculator</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .calculator-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        .operation-group {
            margin: 20px 0;
        }
        
        .operation-group label {
            display: inline-block;
            margin-right: 15px;
            cursor: pointer;
        }
        
        .operation-group input[type="radio"] {
            margin-right: 5px;
        }
        
        .btn-calculate {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-calculate:hover {
            background-color: #0056b3;
        }
        
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        
        .result.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .result.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .result-display {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
            text-align: center;
            font-size: 20px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="calculator-container">
        <h1>PHP Calculator</h1>
    <form action="" method="post">
      <div class="for-group">
        <label for="number1">First Number</label>
        <input type="text" id="number1" name="num1" value="<?php echo htmlspecialchars($num1) ?>"
         step="any">
      </div>
      <div class="for-group">
        <label for="number2">Second Number</label>
        <input type="text" id="number2" name="num2" value="<?php echo htmlspecialchars($num2) ?>"
         step="any">
      </div>
      <div class="operation-group">
        <label >Select Operator</label>
        <label><input type="radio" name="operation" value="+" <?php echo ($operation == '+') ? 'checked' : '' ?>>Addition (+)</label>
        <label><input type="radio" name="operation" value="-" <?php echo ($operation == '-') ? 'checked' : '' ?>>Subtraction (-)</label>
        <label><input type="radio" name="operation" value="*" <?php echo ($operation == '*') ? 'checked' : '' ?>>Multiplication (*)</label>
        <label><input type="radio" name="operation" value="/" <?php echo ($operation == '/') ? 'checked' : '' ?>>Division (/)</label>
        <label><input type="radio" name="operation" value="%" <?php echo ($operation == '%') ? 'checked' : '' ?>>Modulus (%)</label>
      </div>
      <button type="submit" name="submit" class="btn-calcutor">Calculate</button>
    </form>
    <?php if (!empty($error)): ?>
        <div class="result error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php elseif ($result !== ""): ?>
        <div class="result success">
            <strong>Result:</strong>
            <div class="result-display">
                <?php echo htmlspecialchars($num1.' '. $operation. ''. $num2. ' '.'=' . $result ); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>