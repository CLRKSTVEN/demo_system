<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card</title>
    <link rel="shortcut icon" href="<?= base_url(); ?>/assets/images/wcm.ico">
    
    <link href="<?= base_url(); ?>/assets/css/sf9.css" rel="stylesheet" type="text/css" />
</head>
<body>
    
<div class="link">
    <a href="<?= base_url(); ?>Ren/rc_sf9_es/<?= $this->uri->segment(3); ?>">Page 1</a>
</div>


<div class="wrap">


    <div class="cleft">
        <div class="tw">
            <table class="wb">
                <tr>
                    <td colspan="7" class="tdnb">GRADE IV</td>
                </tr>
                <tr>
                    <th colspan="7" class="tdnb" style="padding:20px">REPORT ON LEARNING PROGRESS AND ACHIEVEMENT</th>
                </tr> 
                <tr>
                    <td rowspan="2">Learning Areas</td>
                    <td colspan="4" class="text-center">Quarter</td>
                    <td rowspan="2" class="text-center">Final<br /> Rating</td>
                    <td rowspan="2" class="text-center">Remarks</td>
                </tr> 
                <tr>
                    <td class="text-center">1</td>
                    <td class="text-center">2</td>
                    <td class="text-center">3</td>
                    <td class="text-center">4</td>
                </tr>
                <?php 
                        $ave=0; 
                        foreach($data as $row){ 
                           
                ?>
                    <tr>
                        <td><?= $row->Description; ?></td>
                        <td style='text-align:center'><?php if($row->PGrade != 0){echo $row->PGrade;} ?></td>
                        <td style='text-align:center'><?php if($row->MGrade != 0){echo $row->MGrade;} ?></td>
                        <td style='text-align:center'><?php if($row->PFinalGrade != 0){echo $row->PFinalGrade;} ?></td>
                        <td style='text-align:center'><?php if($row->FGrade != 0){echo $row->FGrade;} ?></td>
                        <td style='text-align:center'><?php if($row->Average != 0){if($row->Average >= 60){echo number_format($row->Average);}} ?></td>
                        <td><?php $ave += $row->Average; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="tdnb"></td>
                    <td colspan="4" class="text-center">General Average</td>
                    <td class="text-center"><?php $final_av = $ave/4; if($final_av >= 60)echo $final_av; ?></td>
                    <td class="tdnb"></td>
                </tr>
                <tr><td colspan="7" class="tdnb">&nbsp;</td></tr>
                <tr>
                    <td class="tdnb"><strong>Discriptors</strong></td>
                    <td class="tdnb"><strong>Grading Scale</strong></td>
                    <td class="tdnb"><strong>Remarks</strong></td>
                </tr>  
                <tr>
                    <td class="tdnb">Outstanding</td>
                    <td class="tdnb">90-100</td>
                    <td class="tdnb">Passed</td>
                </tr> 
                <tr>
                    <td class="tdnb">Very Satisfactory</td>
                    <td class="tdnb">85-89</td>
                    <td class="tdnb">Passed</td>
                </tr>
                <tr>
                    <td class="tdnb">Satisfactory</td>
                    <td class="tdnb">80-84</td>
                    <td class="tdnb">Passed</td>
                </tr>
                <tr>
                    <td class="tdnb">Fairly Satisfactory</td>
                    <td class="tdnb">75-79</td>
                    <td class="tdnb">Passed</td>
                </tr>
                <tr>
                    <td class="tdnb">Did Not Meet Expections</td>
                    <td class="tdnb">Below 75</td>
                    <td class="tdnb">Failed</td>
                </tr>
            </table>
        </div>

    </div>

    <div class="cright">
        <div class="tw">

            <table class="wb">
                    <tr>
                        <th colspan="7" class="tdnb" style="padding:20px">REPORT ON LEARNING PROGRESS AND ACHIEVEMENT</th>
                    </tr> 
                    <tr>
                        <td rowspan="2">Core Values</td>
                        <td rowspan="2">Behavior Statements</td>
                        <td colspan="4" class="text-center">Quarter</td>
                    </tr> 
                    <tr>
                        <td class="text-center">1</td>
                        <td class="text-center">2</td>
                        <td class="text-center">3</td>
                        <td class="text-center">4</td>
                    </tr>
                    <tr>
                        <td>1. Maka-Diyos</td>
                        <td>Expresses one's spiritual<br /> beliefs while respecting<br /> the spiritual beliefs of<br /> others</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>  
                    <tr>
                        <td>2. Makatao</td>
                        <td>Shows adherence to ethical principles<br /> by upholding truth</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr> 
                    <tr>
                        <td>3. Maka-kalikasan</td>
                        <td>Cares for the environment and utilizes resources<br /> wisely, judiciously, and economically</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr> 
                    <tr>
                        <td rowspan="2">4. Makabansa</td>
                        <td>Demonstrates pride in being a Fiulipino; exercises<br /> the rights and responsibilities of a Filipino citizen</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr> 
                    <tr>
                        <td>Demonstrates appropriate behavior in carrying out<br /> activities in the school, community, and country</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr><td colspan="7" class="tdnb">&nbsp;</td></tr>

                    <tr>
                        <td colspan="6" class="tdnb">
                            <table>
                                <tr>
                                    <td class="tdnb text-center"><strong>Marking</strong></td>
                                    <td class="tdnb"><strong>Non-numerical Rating</strong></td>
                                </tr>
                                <tr>
                                    <td class="tdnb text-center">AO</td>
                                    <td class="tdnb">Always Observed</td>
                                </tr>
                                <tr>
                                    <td class="tdnb text-center">SO</td>
                                    <td class="tdnb">Sometimes Observed</td>
                                </tr>
                                <tr>
                                    <td class="tdnb text-center">RO</td>
                                    <td class="tdnb">Rarely Observed</td>
                                </tr>
                                <tr>
                                    <td class="tdnb text-center">NO</td>
                                    <td class="tdnb">Not Observed</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
            </table>
            
        </div>

    </div>


    <div class="blocker"></div>

</div>





</body>
</html>