<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PR</title>

    <style>
        /* General Styles */
        body {
            font-family: Calibri, Arial, sans-serif;
            /* Font set to Calibri */
            font-size: 10px;
            /* Font size set to 10 */
            line-height: 1;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
        }

        /* A4 Paper Size Settings */
        @page {
            size: A4;
            /* Set paper size to A4 */
            margin: 15mm;
            /* Add margins suitable for printing */
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Adjust table font size */
        table th,
        table td {
            font-size: 10px;
            /* Font size set to 10 */
            padding: 5px;
            /* Reduce padding for compact layout */
        }

        /* Table Headings */
        table th {
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
        }

        .letterhead img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            /* border-bottom: 2px solid #333; */
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        h4 {
            text-align: center;
            text-transform: uppercase;
            margin: 10px 0;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 14px;
            border: 1px solid #333 !important;
        }

        table th {
            /* background-color: #333; */
            /* color: #fff; */
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
            border: 1px solid #333 !important;
        }

        .heading table {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 14px;
            border: none !important;
        }

        .heading th {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 14px;
            border: none !important;
        }

        .heading td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 14px;
            border: none !important;
        }

        .signatories td {
            text-transform: uppercase;
            /* Ensures all text in these cells is uppercase */
        }

        .tbody td {
            border-top: none !important;
            border-bottom: none !important;
            line-height: 1 !important;
            /* Adjust this value as needed */
            padding-bottom: 0 !important;
            /* Removes extra padding for compression */
        }




        tfoot td {
            font-weight: bold;
            background-color: #f1f1f1;
        }

        /* .card-body {
    margin-bottom: 20px;
    padding: 15px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
} */

        .card {
            border: none;
            margin: 10px 0;
        }

        .card h4 {
            font-size: 16px;
            color: #444;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        /* Footer */
        tfoot {
            text-align: right;
        }

        tfoot td {
            text-align: right;
            font-size: 14px;
            padding: 10px;
        }

        /* Input Styles */
        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        /* No Border for Heading Table */
        .heading table {
            border: none;
        }

        .heading table td {
            border: none;
            padding: 5px 10px;
        }

        /* Signatures */
        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .signature div {
            text-align: center;
            width: 45%;
        }

        .signature span {
            display: block;
            border-top: 1px solid #333;
            margin-top: 10px;
            font-size: 14px;
            color: #333;
        }

        .textprop1 {
            height: 10em;
            /* Adjust as needed, 1em = approximately the height of one line of text */
            vertical-align: top;
            /* Vertically align the text within the cell */
            padding: 10px;
            /* Adjust padding as needed */
            overflow: hidden;
            /* Ensures content doesn't overflow */

        }

        .porpose {
            border: 1px solid #333 !important;
        }

        /* .porpose table th,
table td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
    font-size: 14px;
    border: none !important;
} */






        .req table tr,
        table td {
            text-align: center;
        }

        /* Remove border for tr and td inside the .req class */
        .req tr,
        .req td {
            border: none !important;
            /* Forcefully remove borders */
            border-style: none !important;
        }


        .signatories {
            width: 100%;
            page-break-inside: avoid;
            display: inline-block;

        }

        .signatories table th {
            display: hidden;

        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background: #fff;
                /* Ensure a white background for print */
            }

            .container {
                padding: 0;
                width: 100%;
                /* Use the full width of the page */
            }

            table {
                page-break-inside: auto;
                width: 100%;
                border-collapse: collapse;
            }

            thead {
                display: table-header-group;
                /* Repeat table headers on each page */
            }

            tbody {
                display: table-row-group;
                /* Body content flows naturally */
            }

            tfoot {
                display: table-footer-group;
                /* Only appears at the bottom of the last page */
                page-break-inside: avoid;
                /* Ensure footer is not split across pages */
            }

            /* Prevent page breaks within the footer block */
            .tfoot-signatories {
                page-break-inside: avoid;
            }

            /* Optional: Style adjustments for printing */
            td,
            th {
                border: 1px solid black;
                padding: 5px;
                text-align: left;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="letterhead">
            <?php
            // Convert the BLOB data to a Base64 string
            $base64Image = base64_encode($letterhead[0]->letterHead);

            // Create a Data URI for the image
            $imageSrc = "data:image/jpeg;base64," . $base64Image;
            ?>

            <!-- Display the image -->
            <img src="<?php echo $imageSrc; ?>" alt="Letterhead" style="max-width: 100%; height: auto; display: block; margin: 0 auto;">
        </div>

        <h4 style="text-align: center;">PURCHASE REQUEST</h4>
        <div class="heading">
            <table>
                <tr>
                    <td>Entry Name:</td>
                    <!-- <td><?php echo $settings[0]->SchoolName; ?></td> -->
                    <td>PR NO.: <?php echo $activities[0]->prNo; ?></td>
                    <!-- <td><?php echo $activities[0]->prNo; ?></td> -->
                    <td>Fund Cluster:</td>
                    <td><?php echo $activities[0]->fundSource; ?></td>
                </tr>
                <tr>
                    <td>Office/Section:</td>
                    <td><?php echo $activities[0]->section; ?></td>
                    <td>Responsibility Center Code:</td>
                    <td>______________</td>
                    <!-- <td><?php echo $activities[0]->user_id; ?></td> -->
                    <td>Date: <?php echo date('F d, Y'); ?> </td>
                    <!-- <td><?php echo date('Y-m-d'); ?></td> -->
                </tr>


            </table>
        </div>

        <div class="bodypart">
            <?php foreach ($activities as $row) { ?>

                <div class="card-body file-manager">
                    <div class="col-sm-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="table-responsive">

                                    <table class="table">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col">Stock/
                                                    Property</th>
                                                <th scope="col">Unit</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Estimated Cost</th>
                                                <th scope="col">Total Cost</th>

                                            </tr>
                                        </thead>
                                        <tbody class="tbody">
                                            <?php
                                            $grandTotal = 0;
                                            $currentLot = null;
                                            $lotTotal = 0; // Initialize the lot total

                                            if (empty($pr)) {
                                                // No records found
                                                echo "<tr><td colspan='7' style='text-align: center;'><strong>NO RECORDS FOUND</strong></td></tr>";
                                            } else {
                                                foreach ($pr as $row) {
                                                    // Check if the lot has changed
                                                    if ($currentLot !== $row->lot) {
                                                        // If this is not the first lot, output the lot total for the previous lot
                                                        if ($currentLot !== null) {
                                                            echo "<tr style='border: 1px solid #333; font-weight: bold;'>
                <td colspan='5' style='text-align: left;'>{$currentLot} Total:</td>
                <td style='text-align: right;'>" . number_format($lotTotal, 2) . "</td>
              </tr>";
                                                        }

                                                        // Start a new lot
                                                        $currentLot = $row->lot;
                                                        $lotTotal = 0; // Reset the lot total

                                                        // Output a new row with the lot value
                                                        echo "<tr><td colspan='7' style='font-weight: bold; text-align: center; border: 1px solid #333 !important; padding: 5px;'> {$currentLot}</td></tr>";
                                                    }

                                                    // Calculate the total for the current item
                                                    $totalCost = 0;
                                                    if (!empty($row->qty) && !empty($row->est_cost)) {
                                                        $totalCost = $row->qty * $row->est_cost;
                                                        $grandTotal += $totalCost;
                                                        $lotTotal += $totalCost;
                                                    }

                                                    // Output the item details
                                                    echo "<tr>";
                                            ?>
                                                    <td></td>
                                                    <td style="text-align: center;"><?php echo $row->unit; ?></td>
                                                    <!-- <td style="text-align: left;"><?php echo isset($row->item_description) && $row->item_description !== null ? $row->item_description : ''; ?></td> -->
                                                    <td style="text-align: left;">
                                                        <?php echo isset($row->item_description) && $row->item_description !== null ? nl2br(htmlspecialchars($row->item_description)) : ''; ?>
                                                    </td>

                                                    <td style="text-align: center;"><?php echo isset($row->qty) && $row->qty !== null ? $row->qty : ''; ?></td>
                                                    <td style="text-align: right;"><?php echo isset($row->est_cost) ? number_format($row->est_cost, 2) : ''; ?></td>
                                                    <td style="text-align: right;"><?php echo number_format($totalCost, 2); ?></td>
                                            <?php
                                                    echo "</tr>";
                                                }

                                                // Output the lot total for the last lot
                                                if ($currentLot !== null) {
                                                    echo "<tr style='border: 1px solid #333; font-weight: bold;'>
                <td colspan='5' style='text-align: left;'>{$currentLot} Total:</td>
                <td style='text-align: right;'>" . number_format($lotTotal, 2) . "</td>
              </tr>";
                                                }

                                                // Output the grand total

                                            }
                                            ?>



                                            <div class="total">
                                                <tr style="border: 1px solid black">
                                                    <td colspan="5" style="text-align: left;"><strong>Grand Total:</strong></td>
                                                    <td colspan="2" style="text-align: right;"><?php echo number_format($grandTotal, 2); ?></td>
                                                </tr>
                                            </div>

                                            <div class="porpose">
                                                <tr style="border: 1px solid #333 !important; border-bottom: none !important;">
                                                    <td style="text-align: left;" colspan="6" class="textprop1">Purpose: <strong> <?php echo $pr[0]->purpose; ?></strong></td>
                                                    <!-- <td colspan="6" class="textprop"><?php echo $pr[0]->purpose; ?></td> -->

                                                </tr>

                                                <tr style="border-right: 1px solid #333 !important; border-left: 1px solid #333 !important; border-bottom: 1px solid #333 !important; border-top: none !important;">
                                                    <td colspan="6">
                                                        <div class="signatories" style="page-break-inside: avoid; display: inline-block;">
                                                            <ul style="list-style: none; margin: 0; padding: 0; border: none; font-size: 12px;">

                                                                <!-- Requested by and Approved by headers -->
                                                                <li style="display: flex; padding-bottom: 20px;">
                                                                    <span style="flex: 2; padding-left: 180px; font-weight: bold; text-align: left;">Requested by:</span>
                                                                    <span style="flex: 2; padding-left: 60px; font-weight: bold; text-align: left;">Approved by:</span>
                                                                </li>

                                                                <li style="display: flex; padding: 2px;">
                                                                    <span style="flex: 1; padding-left: 2px;">Signature:</span>
                                                                    <span style="flex: 2; padding: 2px;">___________________________</span>
                                                                    <span style="flex: 3; padding: 2px;">___________________________</span>
                                                                </li>

                                                                <li style="display: flex; padding: 2px;">
                                                                    <span style="flex: 1; padding-left: 2px;">Printed Name:</span>
                                                                    <span style="flex: 2; padding: 2px;">
                                                                        <strong><?php echo strtoupper($activities[0]->prog_owner); ?></strong>
                                                                    </span>
                                                                    <span style="flex: 3; padding: 2px;">
                                                                        <strong><?php echo strtoupper($settings[0]->SchoolHead); ?></strong>
                                                                    </span>
                                                                </li>

                                                                <li style="display: flex; padding: 2px;">
                                                                    <span style="flex: 1; padding-left: 2px;">Designation:</span>
                                                                    <span style="flex: 2; padding: 2px;">
                                                                        <?php echo strtoupper($activities[0]->prog_owner_position); ?>
                                                                    </span>
                                                                    <span style="flex: 3; padding: 2px;">
                                                                        <?php echo strtoupper($settings[0]->sHeadPosition); ?>
                                                                    </span>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </div>



                                        </tbody>
                                    </table>


                                </div>








                            </div>
                        </div>
                    </div>
                </div>
                <!-- Feature Unable /Disable Ends-->

        </div>
    <?php } ?>
    </div>



    </div>






</body>

</html>