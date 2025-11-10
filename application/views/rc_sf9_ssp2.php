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
    <a href="<?= base_url(); ?>Ren/rc_sf9_ss/<?= $this->uri->segment(3); ?>">Page 1</a>
</div>


<div class="wrap">


    <div class="cleft">
        <div class="tw">
            <table class="wb">
                <tr>
                    <th colspan="4" class="tdnb" style="padding:20px">LEARNER'S PROGRESS REPORT CARD</th>
                </tr> 
                <tr>
                    <td colspan="4" style="border:1px dashed #222"><strong>First Semester</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" class="tdwbc">Subjects</td>
                    <td colspan="2" class="text-center tdwbc">Quarter</td>
                    <td rowspan="2" class="text-center tdwbc">Semester<br />Final Grade</td>
                </tr> 
                <tr>
                    <td class="text-center tdwbc">1</td>
                    <td class="text-center tdwbc">2</td>
                </tr>
                <tr>
                    <td colspan="4" class="tdwbc">Core Subjects</td>
                </tr>
                <?php foreach($data as $row){ ?>
                    <tr>
                        <td><?= $row->Description; ?></td>
                        <td style='text-align:center'><?php if($row->PGrade != 0){echo $row->PGrade;} ?></td>
                        <td style='text-align:center'><?php if($row->MGrade != 0){echo $row->MGrade;} ?></td>
                        <td style='text-align:center'><?php if($row->Average != 0){if($row->Average >= 60){echo number_format($row->Average);}} ?></td>
                  
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="4" class="tdwbc">Applied and Specialized Subjects</td>
                </tr>
                <?php foreach($data as $row){ ?>
                    <tr>
                        <td><?= $row->Description; ?></td>
                        <td style='text-align:center'><?php if($row->PGrade != 0){echo $row->PGrade;} ?></td>
                        <td style='text-align:center'><?php if($row->MGrade != 0){echo $row->MGrade;} ?></td>
                        <td style='text-align:center'><?php if($row->Average != 0){if($row->Average >= 60){echo number_format($row->Average);}} ?></td>
                  
                    </tr>
                <?php } ?>
                <tr>
                    <td class="tdnb" style="border:1px dashed #222 !important"></td>
                    <td colspan="2" class="text-center">General Average for the Semester</td>
                    <td class="text-center"></td>
                </tr>
                <tr><td colspan="4" class="tdnb">&nbsp;</td></tr>
                
            </table>

            <table class="wb">
                <tr>
                    <td colspan="4" style="border:1px dashed #222"><strong>Second Semester</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" class="tdwbc">Subjects</td>
                    <td colspan="2" class="text-center tdwbc">Quarter</td>
                    <td rowspan="2" class="text-center tdwbc">Semester<br />Final Grade</td>
                </tr> 
                <tr>
                    <td class="text-center tdwbc">1</td>
                    <td class="text-center tdwbc">2</td>
                </tr>
                <tr>
                    <td colspan="4" class="tdwbc">Core Subjects</td>
                </tr>
                <?php foreach($data as $row){ ?>
                    <tr>
                        <td><?= $row->Description; ?></td>
                        <td style='text-align:center'><?php if($row->PGrade != 0){echo $row->PGrade;} ?></td>
                        <td style='text-align:center'><?php if($row->MGrade != 0){echo $row->MGrade;} ?></td>
                        <td style='text-align:center'><?php if($row->Average != 0){if($row->Average >= 60){echo number_format($row->Average);}} ?></td>
                  
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="4" class="tdwbc">Applied and Specialized Subjects</td>
                </tr>
                <?php foreach($data as $row){ ?>
                    <tr>
                        <td><?= $row->Description; ?></td>
                        <td style='text-align:center'><?php if($row->PGrade != 0){echo $row->PGrade;} ?></td>
                        <td style='text-align:center'><?php if($row->MGrade != 0){echo $row->MGrade;} ?></td>
                        <td style='text-align:center'><?php if($row->Average != 0){if($row->Average >= 60){echo number_format($row->Average);}} ?></td>
                  
                    </tr>
                <?php } ?>
                <tr>
                    <td class="tdnb" style="border:1px dashed #222 !important"></td>
                    <td colspan="2" class="text-center">General Average for the Semester</td>
                    <td class="text-center"></td>
                </tr>
                <tr><td colspan="4" class="tdnb">&nbsp;</td></tr>
                
            </table>
        </div>

    </div>

    <div class="cright">
        <div class="tw">

            <table class="wb">
                    <tr>
                        <th colspan="7" class="tdnb" style="padding:20px">REPORT ON LEARNER'S OBSERVES VALUES</th>
                    </tr> 
                    <tr>
                        <td rowspan="2" class="tdwbc"><strong>Core Values</strong></td>
                        <td rowspan="2" class="tdwbc"><strong>Behavior Statements</strong></td>
                        <td colspan="4" class="text-center tdwbc"><strong>Quarter</strong></td>
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
                    
            </table>

            <table class="twb" style="width:80%">
                        <tr>
                            <td colspan="2"><strong>Observed Values</strong></td>
                        </tr>
                                <tr>
                                    <td class="text-center"><strong>Marking</strong></td>
                                    <td><strong>Non-numerical Rating</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-center">AO</td>
                                    <td>Always Observed</td>
                                </tr>
                                <tr>
                                    <td class="text-center">SO</td>
                                    <td>Sometimes Observed</td>
                                </tr>
                                <tr>
                                    <td class="text-center">RO</td>
                                    <td>Rarely Observed</td>
                                </tr>
                                <tr>
                                    <td class="text-center">NO</td>
                                    <td>Not Observed</td>
                                </tr>
            </table>

            <table class="twb">
                <tr>
                    <td colspan="3"><strong>Learner Progress and Achievment</strong></td>
                </tr>
                        <tr>
                            <td class="pl30"><strong>Discriptors</strong></td>
                            <td><strong>Grading Scale</strong></td>
                            <td><strong>Remarks</strong></td>
                        </tr>  
                        <tr>
                            <td class="pl30">Outstanding</td>
                            <td>90-100</td>
                            <td>Passed</td>
                        </tr> 
                        <tr>
                            <td class="pl30">Very Satisfactory</td>
                            <td>85-89</td>
                            <td>Passed</td>
                        </tr>
                        <tr>
                            <td class="pl30">Satisfactory</td>
                            <td>80-84</td>
                            <td>Passed</td>
                        </tr>
                        <tr>
                            <td class="pl30">Fairly Satisfactory</td>
                            <td>75-79</td>
                            <td>Passed</td>
                        </tr>
                        <tr>
                            <td class="pl30">Did Not Meet Expections</td>
                            <td>Below 75</td>
                            <td>Failed</td>
                        </tr>
                    </table>
            
        </div>

    </div>


    <div class="blocker"></div>

</div>





</body>
</html>