<?php
// Include local file 'address_data_store.php'
require_once('file_store.php');
class AddressDataStore extends Filestore {

}

$book = new AddressDataStore('assets/Data/address_book.csv');
$book_array = $book->read();
$error = '';

class InvaidInputException extends Exception{}

try{
	// Error validation
	if (!empty($_POST)) {
		$entry = [];
		$entry['Name'] = $_POST['Name'];	
		$entry['Address'] = $_POST['Address'];
		$entry['City'] = $_POST['City'];
		$entry['State'] = $_POST['State'];
		$entry['ZipCode'] = $_POST['ZipCode'];
		// Organizing error messages
		foreach ($entry as $key => $value) {
			if (empty($value)) {
				$error[] =" ucfirst($key)" . " is not found";
				throw new InvaidInputException("$key value is empty.");
			} else {
				$entries[] = $value;
			}
			if (strlen($value) > 125) {
				throw new InvaidInputException("$key value is greater than 125 characters.");
			}
		}

		$entry['Phone'] = $_POST['Phone'];
		foreach ($_POST as $key => $value) {
			$_POST[$key] = ($value);
		}

		// If there are no errors, go ahead and save the address book
		if (empty($errors)) {
			array_push($book_array, array_values($entries));
			$book->save($book_array);
		}
	} 
} catch (InvaidInputException $e) {
	echo "<font color='red'><h2>Please enter" . " " . ($key) ." </h2></font>";
}





	if (isset($_GET['key'])) {
		//Remove item from address_book array 
		//Save array to data storage
		foreach ($book_array as $key => $data) {
			if ($_GET['key'] == $key) {
				unset($book_array[$key]);				
				}
			$book->save($book_array);
			}
		}

if (count($_FILES) > 0 && $_FILES['Upload']['error'] == 0 && $_FILES['Upload']['type'] == 'text/csv') {
	    // Set the destination directory for uploads
	    $upload_dir = '/vagrant/sites/codeup.dev/public/assets/uploads/';
	    // Grab the filename from the uploaded file by using basename
	    $tempfilename = basename($_FILES['Upload']['name']);
	    // Create the saved filename using the file's original name and our upload directory
	    $newlist->filename = $upload_dir . $tempfilename;
	    // Move the file from the temp location to our uploads directory
	    move_uplofile1aded_file($_FILES['Upload']['tmp_name'], $newlist->filename);
	    $appendList = $newlist->read();
	    if (isset($_POST['overwrite']) && $_POST['overwrite'] == "yes") {
	    	$addressBook = $appendList;
	    	$book->read($addressBook);
	    } else {
	    	$addressBook = array_merge($addressBook, $appendList);
	    	$book->save($addressBook);
	    }
	}
	  		

	



// var_dump($new_items);	

?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Adress Book</title>
</head>
<body>

<h1 align="center">ADDRESS BOOK</h1>	

<table border="3px" style="width:800px" align="center">
<colgroup>
   <col span='7' style="background-color:gray">
 </colgroup>
<tr>
  <th>Name</th>
  <th>Address</th> 
  <th>City</th>
  <th>State</th>
  <th>ZipCode</th> 
  <th>Phone</th>
  <th></th>

</tr>

<tr>
<? foreach($book_array as $key => $address): ?>
					<tr>
						<? foreach($address as $data): ?>
							<td><?= htmlspecialchars(strip_tags("{$data}")) ?></td>
						<? endforeach; ?>
						<td><?="<a id='remove' name='remove' href='address_book.php?key=$key'> Remove </a>" ?></td>
					</tr>
				<? endforeach; ?>
			

</tr>



 


</table>



<h1 align="center">Add a new entry to the Address Book</h1>
				
	
	    <form align="center" method="POST" action="address_book.php">
	        <p>
	            <input id="Name" name="Name" placeholder="Name" type="text"  value="<?if(isset($_POST['Name']) && isset($error)){echo htmlspecialchars($_POST['Name'], ENT_QUOTES);}?>" autofocus='autofocus' required>
	       
	            <input id="Address" name="Address" placeholder="Address" value="<?if(isset($_POST['Address']) && isset($error)){echo htmlspecialchars($_POST['Address'], ENT_QUOTES);}?>" type="text" required>
	        
	            <input id="City" name="City" placeholder="City" value= "<?if(isset($_POST['City']) && isset($error)){echo htmlspecialchars($_POST['City'], ENT_QUOTES);}?>" type="text" required>
	      
	            <input id="State" name="State" placeholder="State" value="<?if(isset($_POST['State']) && isset($error)){echo htmlspecialchars($_POST['State'], ENT_QUOTES);}?>" type="text" required>
	       
	            <input id="ZipCode" name="ZipCode" placeholder="ZipCode" value= "<?if(isset($_POST['ZipCode']) && isset($error)){echo htmlspecialchars($_POST['ZipCode'], ENT_QUOTES);}?>" type="text" required>
	    
	            <input id="Phone" name="Phone" placeholder="Phone" type="text" >
	   
				<button class="btn btn-success btn-md" type="submit" id="submit" name="submit">Submit</button>

				<? if(isset($error)): ?>
					<p>
						<?= "{$error}" ?>
					</p>
				<? endif; ?>
				
	        </p>

		</form>

		<form align="center" method="POST" enctype="multipart/form-data" action="">
	    	<p>
	    	    <label for="Upload"><h2>File to upload: </h2></label>
	    	    <input type="file" id="Upload" name="Upload">
	    	</p>
	    	<p>
			    <label for="overwrite">
				    <input type="checkbox" id="overwrite" name="overwrite" value="yes"> Overwrite address book?
				</label>
			</p>
	    	<p>
	    	    <button type="submit" value="Upload">Upload</button>	
	    	</p>
	    

	    </form> 

</body>
<hr>
<footer>
	<!-- <p>&copy 2014 Jaime Velasco</p> -->
</footer>
</html>	