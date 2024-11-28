<footer class="site-footer section-padding" id="contact">
            <div class="container">
                <div class="row">

                    <div class="col-lg-5 me-auto col-12">
                        <?php
$sql="SELECT * from tblpage where PageType='contactus'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                        <h5 class="mb-lg-4 mb-3">Opening Hour</h5>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex">

                                <?php  echo ($row->Timing);?>
                            </li></ul>
                            <h5 class="mb-lg-4 mb-3">Email:</h5>
                            <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex">
                                <?php  echo ($row->Email);?></li>
                                <br>
                                 <h5 class="mb-lg-4 mb-3">Call Us:</h5>
                            <li class="list-group-item d-flex">
                                <?php  echo ($row->MobileNumber);?></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-6 col-12 my-4 my-lg-0">
                        <h5 class="mb-lg-4 mb-3">Address</h5>

                     

                        <p><?php  echo ($row->PageDescription);?></p>
                    </div>
<?php $cnt=$cnt+1;}} ?>
                   

                   

                </div>
            </section>
        </footer>