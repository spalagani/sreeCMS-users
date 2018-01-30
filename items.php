<?php ob_start();

session_start();

include('sessionchk.php');

include('../includes/dbconfig.php');

include('../includes/constants.php');

extract($_REQUEST);

?>

<html>

<head>

<link href="images/style.css" rel="stylesheet" type="text/css" />

<script language="javascript" src='validation.js'></script>






<script language="javascript" type="text/javascript" src="includes/scripts.js"></script>

<script language="javascript">

function delete1(uid){

	if(confirm("Are you sure want to delete?")){

		document.location.href = 'items.php?del=1&uid='+uid;

	}

}

function open_window(img_name)

{

	url = "../images/categories/"+img_name;

	window.open(url,'MyWin','resizable=no,scrollbars=yes,width=200,height=200,left=400,top=250');

}

function open_window1(img_name)

{

	url = "../images/"+img_name;

	window.open(url,'MyWin','resizable=no,scrollbars=yes,width=200,height=200,left=400,top=250');

}

</script>

<script type="text/javascript">

function itemsorting()

{



var sortvalue=document.formx1.itemdisplay.value;

document.formx1.action='items.php?sortid='+sortvalue+'&act=view';

document.formx1.submit();

}





</script>






</head>

<?php ///////////////////////////////single delete/////////////////////////////////

	$del=$_REQUEST['del'];

	$uid=$_REQUEST['uid'];

	if($del==1)

	{

			

			//delete_directory("../images/categories/".$name."/");



			$delete2=mysqli_query($con,"delete from sree_userlist where sid='$uid'");

			header("location:items.php?act=view");

			exit;

			

	}

///////////////////////////////////////multiple delete///////////////////////////

	$ok=$_REQUEST[ok];

	$colors=$_REQUEST['chk'];

	$chk1=$_REQUEST['chk1'];

	$number=count($colors);

	if($ok=='alldel')

	{

		foreach($colors as $chk1)

		{

			

			$delete2=mysqli_query($con,"delete from sree_userlist where sid='$chk1'");

		}

		header("location:items.php?act=view");

		exit;	

			

	}

//////////////////////////////end of multiple delete///////////////////////////////////	

$ok=$_REQUEST[ok];

//echo $ok;exit;

//////////////////////////////////////ADD////////////////////////////////////////////

if($ok==add)

{

	//echo "SELECT * FROM auc_categories WHERE listing_id='$listing_id' and name='$name'";exit;

	$selCat = mysqli_query("SELECT * FROM sree_userlist WHERE Username='$Username'");

	//echo "SELECT * FROM nile_category WHERE cat_name='$catname'";exit;

	$num=mysqli_num_rows($selCat);

	if($num<=0)

	{
			
						

		$sql=mysqli_query($con, "INSERT INTO `sree_userlist` (`sid`, `Status`, `Username`, `Name`, `Date_Added`, `price`, `Package_Name`, `Mobile_Number`, `idproof`, `IpAddress`, `noofmonths`, `installationamount`, `wifirouter`, `Branch`, `Billing_Address`, `comments`) VALUES ('', '$status', '$username', '$Name', now(), '$price', '$Package_Name', '$Mobile_Number', '$idproof', '$IpAddress', '$noofmonths', '$installationamount', '$wifirouter', '$Branch', '$Billing_Address', '$comments')");

		

		

		header("location:items.php?act=view");

		exit;

	}

	else

	{

		header("location:items.php?act=new&error=1");

		exit;

	}

	

}

//////////////////////////////////////update////////////////////////////////////////////

if($ok==edit)

{	

extract($_REQUEST);

		
//echo $aid;
	//echo "select * from sree_userlist where sid ='$idno'";
	//exit;
	//exit;
		//echo $have_hins;

		$sql_filetype=mysqli_query($con,"select * from sree_userlist where sid ='$idno'");

		$row_filetype=mysqli_fetch_array($sql_filetype);

		

	

		$sql=mysqli_query($con,"select * from sree_userlist where sid ='$idno'");

		$row=mysqli_fetch_array($sql);

		$cc=mysqli_num_rows($sql);

		if($cc>0)

		{	

				

			

			//echo 	"UPDATE `sree_userlist` SET `Status` = '$status', `Username` = '$username', `Name` = '$Name',  `price` = '$price', `Package_Name` = '$Package_Name', `Mobile_Number` = '$Mobile_Number', `idproof` = '$idproof', `IpAddress` = '$IpAddress', `noofmonths` = '$noofmonths', `installationamount` = '$installationamount', `wifirouter` = '$wifirouter', `Branch` = '$Branch', `Billing_Address` = '$Billing_Address', `comments` = '$comments' WHERE `sid` = '$idno'";
//echo $status;
			
			//exit;
			
 mysqli_query($con,"UPDATE `sree_userlist` SET `Status` = '$status', `Username` = '$username', `Name` = '$Name',  `price` = '$price', `Package_Name` = '$Package_Name', `Mobile_Number` = '$Mobile_Number', `idproof` = '$idproof', `IpAddress` = '$IpAddress', `noofmonths` = '$noofmonths', `installationamount` = '$installationamount', `wifirouter` = '$wifirouter', `Branch` = '$Branch', `Billing_Address` = '$Billing_Address', `comments` = '$comments' WHERE `sid` = '$idno'");

	//$id="a_".$idno;

		//exit;

	header("location:items.php?act=view");

	exit;

	}

	else

	{

		header("location:items.php?act=view&error=1");

		exit;

	}

}

///////////////////paging////////////////////

$PageSize = 45;

$StartRow = 0;

if(empty($_GET['PageNo'])){

    if($StartRow == 0){

        $PageNo = $StartRow + 1;

    }

}else{

    $PageNo = $_GET['PageNo'];

    $StartRow = ($PageNo - 1) * $PageSize;

}



if($PageNo % $PageSize == 0){

    $CounterStart = $PageNo - ($PageSize - 1);

}else{

    $CounterStart = $PageNo - ($PageNo % $PageSize) + 1;

}

//Counter End

$CounterEnd = $CounterStart + ($PageSize - 1);

//////////////////end //////////////////////////////



	

	$TRecord=mysqli_query($con,"select * from sree_userlist order by date_added desc");

	$sql=mysqli_query($con,"select * from sree_userlist order by date_added  desc LIMIT ". $StartRow .",". $PageSize."");





$RecordCount = mysqli_num_rows($TRecord);

$MaxPage = $RecordCount % $PageSize;

if($RecordCount % $PageSize == 0){

    $MaxPage = $RecordCount / $PageSize;

 }

else{

    $MaxPage = ceil($RecordCount / $PageSize);

 }



$num=mysqli_num_rows($sql);



if(($_REQUEST['sortid']<>''))

{

$act=$_REQUEST['act'];

 $sid=$_REQUEST['sortid'];

 

$TRecord=mysqli_query($con,"select * from sree_userlist where  Branch='$sid' order by date_added desc");

	$sql=mysqli_query($con,"select * from sree_userlist where  Branch='$sid' order by date_added desc LIMIT ". $StartRow .",". $PageSize."");



//echo "select * from sree_userlist where  Branch='$sid' order by date_added desc";

 $RecordCount = mysqli_num_rows($TRecord);

$MaxPage = $RecordCount % $PageSize;

if($RecordCount % $PageSize == 0){

    $MaxPage = $RecordCount / $PageSize;

 }

else{

    $MaxPage = ceil($RecordCount / $PageSize);

 }



 $num=mysqli_num_rows($sql);



}



?>





<body >

	<TABLE cellSpacing=0 cellPadding=0 width=96% align=center border="0">

	

	<tr>

	<td>

	

	          <!--VIEW USERS -->

			  <?php if($act=="view"){?>

	<form name="formx1" method="post" enctype="multipart/form-data" id="formx1" >

	

<table width="100%" border="0">

	

	<tr>

		<td height="40" align="center" class="style13" colspan="3">&nbsp;<b class="greentext22bold" >View Items </b></td>

	</tr>

	<?php if($num<=0){?>

		<tr>

			<td height="40" colspan="2" align="center" class="style1">

			<?php echo "Item Does not exists";

				

				

				//header("Location:nileinfo_items.php?act=new");

			?>

			

			<a href="#" onClick="javascript:history.go(-1);" class="greenlink">Go Back</a>&nbsp;&nbsp;&nbsp;	<a href="items.php?act=new" class="greentextbold">Add Books </a>		</td>

		</tr>

	<?php } else { ?>

					<?php $cat1=mysqli_query($con,"Select * from nile_category where status='1'");

						

						?>

						

					<tr class="txtblack3" >

					

					<td  width="91%" align="center">

					

					  <select name="itemdisplay" onChange="itemsorting()">

					<option value="">Select Item category</option>

					<?php while ($values=mysqli_fetch_array($cat1)){?>

					<option value="<?php echo $values['cat_name']?>" <?php if($sortid==$values['cat_id']){ ?> selected <?php } ?>><?php echo $values['cat_name']?></option>

					<?php } ?>

					</select>

					

					</td>

					  <td width="9%" height="10" colspan="10" align="right" class="normal" ><a href="items.php?act=new" class="greentextbold">Add Book</a></td>

	  </tr>

					<tr class="txtblack3" >

					  <td height="10" align="center" class="normal" colspan="10" ><span class="style14">

					    <?php if($error==1)

					  {

					  	echo "Item already exists";

					  }

					  ?>

					  </span></td>

	  </tr>

					<tr class="txtblack3" >

					<td height="10" align="right" class="normal" colspan="10" ><b ><strong><font color="#FF0000">Page: <?php echo $PageNo." of ". $MaxPage  ?></font></strong></b></td>

				</tr>

	

	<tr>

		<td colspan="2" align="center" valign="middle">

			<table width=100% border="0" align=center cellPadding=0 cellSpacing=0 frame="box" style="border-style:solid; border-width:1px; border-color:#999999" >

				<tr class="txtblack3" bgcolor="#FA9032" >

				  <td width="46" align="center" class="style12"><input type="checkbox" name="selall" onClick="checkstate('chk[]')" ></td>

				  <td width="98" height="31" bgcolor="#FA9032" class="style12" ><div align="center" class="itemstyle"><b>Customer Name</b></div></td>
				  <td width="98" bgcolor="#FA9032" class="style12" ><div align="center" class="itemstyle"><b>User Name</b></div></td>

				  <td width="58" bgcolor="#FA9032" class="style12" ><div align="center" class="itemstyle"><b> Branch</b></div></td>
				  <td width="59" bgcolor="#FA9032" class="style12" ><div align="center" class="itemstyle"><b> Package Name</b></div></td>
				  <td width="59" bgcolor="#FA9032" class="style12" ><div align="center" class="itemstyle"><b>IP Address</b></div></td>
				  <td width="59" bgcolor="#FA9032" class="style12" ><div align="center" class="itemstyle"><b>Address</b></div></td>

				  <td width="88" height="31" bgcolor="#FA9032" class="style12" ><div align="center" class="itemstyle"><b>Status</b></div></td>

				  <td width="49" align="center" bgcolor="#FA9032" class="style12"><b class="itemstyle">Edit</b></td>

					<td width="61" align="center" bgcolor="#FA9032" class="style12"><b class="itemstyle">Delete</b></td>

			  </tr>

<?php while($row=mysqli_fetch_array($sql))

{ 

	

?>

				<tr style="background-color:#FFFFFF" onMouseOver="javascript:MouseOverMenu(this);" onMouseOut="javascript:MouseOutMenu(this);">

						<td align="center" class="style12"><input type="hidden" name="chk1[]"  id="chk1" value="<?php echo $row['item_id']; ?>"> 

   					  <input type="checkbox" name="chk[]"  id="chk" value="<?php echo $row['item_id']; ?>" onClick="checkval('chk[]')"></td>

				

				    <td height="28" class="normal style12"><div align="center">

					  <?php echo $row['Name']?>

				    </div></td>
			      <td height="28" class="normal style12"><div align="center"> <?php echo $row['Username']?> </div></td>

					


					 <td class="normal style12"><div align="center">
					   <?php echo $row['Branch']?>
					   
				     </div></td>
				  <td class="normal style12"><div align="center"> <?php echo $row['Package_Name']?> </div></td>
				  <td class="normal style12"><div align="center"> <?php echo $row['IpAddress']?> </div></td>
				  <td class="normal style12"><div align="center"> <?php echo $row['Billing_Address']?></div></td>

				    <td height="28" class="normal style12"><div align="center">

					  <?php echo $row['Status'] ?>

				    </div></td>

					<td height="28" class="normal style12"><div align="center">

					  <a href="items.php?act=edit&aid=<?php echo $row['sid']?>"><img src="images/edit_f2.png" width="18" height="18" border="0"></a>

				    </div></td>

					<td height="28" class="normal style12"><div align="center">

					   <a href="javascript:delete1(<?php echo $row['sid']?>)">

					   <img src="images/delete.png" width="18" height="18" border="0"></a>

				    </div></td>

			  </tr><?php }

					?>

		  </table>	  </td>

		  </tr><tr><td colspan="2">&nbsp;</td></tr>

					<tr>

					  <td align="center" colspan="2"><img src="images/delete1.gif" onClick="javascript:document.formx1.action='items.php?ok=alldel';document.formx1.submit();"><!--<input name="delete" type="button" class="greentextbold" onClick="javascript:document.formx1.action='items.php?ok=alldel';document.formx1.submit();" value="Delete">--></td>

	  </tr>

					<tr>

					  <td align="right" class="normal" colspan="2">

					  <?php

      	//Print First & Previous Link is necessary

        if($CounterStart != 1){

            $PrevStart = $CounterStart - 1;

            print "<a href=items.php?PageNo=1&sortid=$sortid&act=view class=greenlink>First </a>: ";

            print "<a href=items.php?PageNo=1&sortid=$sortid&act=view class=greenlink>Previous </a>";

        }

        print " <font color='red'><b> [ </b></font>";

        $c = 0;



        //Print Page No

        for($c=$CounterStart;$c<=$CounterEnd;$c++){

            if($c < $MaxPage){

                if($c == $PageNo){

                    if($c % $PageSize == 0){

                        print "$c ";

                    }else{

                        print "$c , ";

                    }

                }elseif($c % $PageSize == 0){

                    echo "<a href=items.php?PageNo=$c&sortid=$sortid&act=view class=greenlink>$c</a> ";

                }else{

                    echo "<a href=items.php?PageNo=$c&sortid=$sortid&act=view class=greenlink>$c</a> , ";

                }//END IF





            }else{

                if($PageNo == $MaxPage){

                    print "$c ";

                    break;

                }else{

                    echo "<a href=items.php?PageNo=$c&sortid=$sortid&act=view class=greenlink>$c</a> ";

                    break;

                }

            }

       }



      echo "<font color='red'><b> ]</b> </font> ";



      if($CounterEnd < $MaxPage){



          $NextPage = $CounterEnd + 1;

          echo "<a href=items.php?PageNo=$NextPage&sortid=$sortid&act=view class=greenlink>Next</a>";

      }

      

      //Print Last link if necessary

      if($CounterEnd < $MaxPage){

       $LastRec = $RecordCount % $PageSize;

        if($LastRec == 0){

            $LastStartRecord = $RecordCount - $PageSize;

        }

        else{

            $LastStartRecord = $RecordCount - $LastRec;

        }



        print " : ";

        echo "<a href=items.php?PageNo=$MaxPage&sortid=$sortid&act=view class=greenlink>Last</a>";

        }?></td>

	  </tr>

	

	</table></form>

	

	<?php }}

	?>

	</td></tr>

					<tr>

					  <td align="center">&nbsp;</td>

	  </tr>

					<tr>

					  <td align="left">

					  

					  			<!--ADD and EDIT -->

					  <?php if($act=='new' || $act=='edit') {

					   if($act == 'edit'){

					$chn=mysqli_query($con,"select * from sree_userlist where sid='$aid'");

					$row=mysqli_fetch_array($chn);

					extract($row);

					$selcat=mysqli_query($con,"select * from nile_category where cat_id='$row[cat_id]'");

					$res=mysqli_fetch_array($selcat);

					}

					  ?>

					  <form name="formx1" method="post" enctype="multipart/form-data">

						<input type="hidden" name='idno' value="<?php echo $sid ?>">

						<input type="hidden" name='oldname' value="<?php echo $item_name?>">

					  <TABLE cellSpacing=0 cellPadding=0 width=100% align=center border="0">

                        <tr>

                          <td height="40" colspan="3" align="center" class="txtnolink">&nbsp;<b class="greentext22bold">

                            <?php if($aid){

							?>

                            Edit Items Details

  <?php }else {?>

                            Add Items Details

  <?php }?>

                          </b></td>

                        </tr>

						<tr>

						<td colspan="3" align="center" class="style14">

						<?php if($error==1)

						{

							echo "Category already Exists";

						}

						?>						</td>

						</tr>

                        <tr>

                          <td height="40" colspan="3" align="right" class="txtnolink"><a href="items.php?act=view" class="greentextbold"><b>View Books </b></a>&nbsp;</td>

                        </tr>

						

						<?php
echo $aid;
							$selcat=mysqli_query($con,"select * from nile_category where status=1"); 

						?>

						 <TR>

                          <TD width="415" height="30" align="right" class="itemstyle">Select Branch</TD>

                          <TD width="33" align="center">:</TD>	

                          <TD width="472"><select name="Branch" >

                                        <option value="">Select</option>

						  				<?php while($retcat=mysqli_fetch_array($selcat)) { ?>

										<option value="<?php echo $retcat['cat_name']?>" <?php if($retcat['cat_name'] == $Branch){ ?> selected <?php } ?>>

										<?php echo $retcat['cat_name']?>										</option>

										<?php } ?>

						  				</select>						 </TD>

                        </TR>

					<?php

							$selcat=mysqli_query($con,"select * from plans where status=1"); 

						?>
						<TR >

                          <TD width="415" height="30" align="right" class="itemstyle">Select Plan </TD>

                          <TD width="33" align="center">:</TD>

                          <TD width="472"><select name="Package_Name" >

                                        <option value="">Select</option>

						  				<?php while($retcat=mysqli_fetch_array($selcat)) { ?>

										<option value="<?php echo $retcat['plan_name']?>" <?php if($retcat['plan_name'] == $Package_Name){ ?> selected <?php } ?>>

										<?php echo $retcat['plan_name']?>										</option>

										<?php } ?>

						  				</select></TD>

                        </TR>
						<TR>

                          <TD height="30" align="right" class="itemstyle">Username / Mobile Number</TD>

						  <TD align="center">:</TD>

						  <TD><input name="username" id="username" value="<?php echo $Username?>" size=25></TD>

					    </TR>
						<TR>

                          <TD height="30" align="right" class="itemstyle">Name</TD>

						  <TD align="center">:</TD>

						  <TD><input name="Name" id="Name" value="<?php echo $Name?>" size=25></TD>

					    </TR>
					    <TR>

                          <TD height="30" align="right" class="itemstyle">Ip Address</TD>

						  <TD align="center">:</TD>

						  <TD><input name="IpAddress" id="IpAddress" value="<?php echo $IpAddress; ?>" size=25></TD>

					    </TR>
					     <TR>

                          <TD height="30" align="right" class="itemstyle">Monthly Charges</TD>

						  <TD align="center">:</TD>

						  <TD><input name="price" id="price" value="<?php echo $price; ?>" size=25></TD>

					    </TR>

						 <?php if(isset($aid) && $act=='edit'){ ?>

                        <?php }?>

						

					    <?php if($act == 'edit'){?>



						

						<?php }?>

						<TR>

                          <TD width="415" height="30" align="right" class="itemstyle">Address</TD>

                          <TD width="33" align="center">:</TD>	

                          <TD width="472"><textarea name="Billing_Address" id="Billing_Address" cols="45" rows="5"><?php echo $Billing_Address?></textarea>                          </TD>

                        </TR>

						 



						<TR >

                          <TD width="415" height="30" align="right" class="itemstyle">Aadhar Number / PAN / Driving Licence</TD>

                          <TD width="33" align="center">:</TD>

                          <TD width="472"><input name="idproof" id="idproof" value="<?php echo $idproof?>" size=25></TD>

                        </TR>

                        

						<TR>

						  <TD height="30" align="right" class="itemstyle">No. Of Months</TD>

						  <TD align="center">:</TD>

						  <td align="left" class="normal"><input name="noofmonths" id="noofmonths" value="<?php echo $noofmonths; ?>" size=25></td>

					    </TR>
					    <TR>

						  <TD height="30" align="right" class="itemstyle">Installation Amount</TD>

						  <TD align="center">:</TD>

						  <td align="left" class="normal"><input name="installationamount" id="installationamount" value="<?php echo $installationamount; ?>" size=25></td>

					    </TR>
					    <TR>

						  <TD height="30" align="right" class="itemstyle">WiFi Router</TD>

						  <TD align="center">:</TD>

						  <td align="left" class="normal"><input name="wifirouter" id="wifirouter" value="<?php echo $wifirouter; ?>" size=25></td>

					    </TR>
					    <TR>

                          <TD width="415" height="30" align="right" class="itemstyle">Comments</TD>

                          <TD width="33" align="center">:</TD>	

                          <TD width="472"><textarea name="comments" id="comments" cols="45" rows="5"><?php echo $comments?></textarea>                          </TD>

                        </TR>

						<TR>

                          <TD height="30" align="right" class="itemstyle">Status</TD>

                          <TD align="center">:</TD>

                          <td align="left" class="normal">
                            <input name="status" type="radio" value="Activation Pending" checked />

                            Activation Pending

                            <input name="status" type="radio" value="active" <?php if($Status == active ){ echo "checked";}?>>

                            Active
                            
                            <input name="status" type="radio" value="expired" <?php if($Status == expired ){ echo "checked";}?>>

                            Expired
                            
                          </td>

                        </TR>

                        <TR>

                          <TD height="60" colspan="3" align="center"><?php if($aid){

			?>

                              <img src="images/update.gif"  onClick="javascript:return items1();"><!--<input name="submit" type="submit" class="normal" onClick="javascript:return items1();" value='Update'>-->

                              <?php } else {

		?>

                <img src="images/additems.gif"  onClick="javascript:return items();"><!--<input name="submit" type="submit" class="normal" onClick="javascript:return items();" value='Add Categories'>-->

                            <?php }?>

                            &nbsp;

                            <img src="images/cancel.gif" onClick="javascript:document.formx1.action='items.php?act=view';document.formx1.submit();"><!--<input name="submit1" type="submit" class="normal" onClick="javascript:document.formx1.action='items.php?act=view';document.formx1.submit();" value="Cancel">-->                          </TD>

                        </TR>

                        <TR>

                          <TD height="50" colspan="3">&nbsp;</TD>

                        </TR>

                      </TABLE>

					  <?php }

					  ?>

					  </form>

					 <!-- END ADD AND EDIT -->

					  

					  </td>

	  </tr>

					<tr>

					  <td align="center">&nbsp;</td>

	  </tr>

					<tr><td align="center">&nbsp;</td>

					</tr>

					

					</TABLE>



					</body>

					</html>

			
