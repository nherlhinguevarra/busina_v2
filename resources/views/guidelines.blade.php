@extends('layouts.main1')

@section('title', 'Guidelines')

@section('header', 'Guidelines Header')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{ asset('storage/css/app1.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script> -->
    @vite(['storage/app/public/css/app1.css', 'storage/app/public/js/app.js'])
</head>

<body>
<div class="cont-g">
    <div class="box-g">
        <ul>
            <li class="guide-title-1">BICOL UNIVERSITY</li>
            <li class="guide-title-2">PARKING AND TRAFFIC GUIDELINES</li>
            <li class="guide-title-3">ADMINISTRATIVE ORDER #384 S.2021</li>
        </ul>
    </div>
</div>

<div class="cont-g-2">
    <div class="box-g-2">
        <ul>
            <li>Section 3</li>
            <li>Section 4</li>
            <li>Section 5</li>
            <li>Section 6</li>
            <li>Section 7</li>
            <li>Section 8</li>
            <li>Section 9</li>
            <li>Section 10</li>
            <li>Section 11</li>
            <li>Section 12</li>
            <li>Section 13</li>
            <li>Section 14</li>
            <li>Section 15</li>
            <li>Section 16</li>
            <li>Section 17</li>
            <li>Section 18</li>
            <li>Section 19</li>
            <li>Section 20</li>
            <li>Section 21</li>
            <li>Section 22</li>
        </ul>
    </div>
    <div class="box-g-2">
        <h3>PARKING GUIDELINES</h3>
        <h4>Section 3. Designation of Appropriate Parking Space</h4>
        <p>Parking of motorized and non-motorized vehicle is allowed
        only at designated parking areas for employees, visitors and
        other University stakeholders. The concerned Deans/Directors
        shall designate authorized parking space within their
        premises. For GASS, the Vice President for Administration and
        Finance shall designate authorized parking space and
        for BU Auxiliary, the Vice President for Academic Affairs.
        </p>

        <h4>Section 4. BU Motorpool Parking</h4>
        <p>The designated parking for BU Motorpool vehicles shall be used
        exclusively for University vehicles only. Any driver who parks a
        vehicle in the area reserved for BU vehicles shall be penalized
        in accordance with the succeeding sections.
        </p>

        <h4>Section 5. Non-assumption of any liability for loss of things 
        or damages in in parking spaces</h4>
        <p>The University assumes no liability for any loss or damage
        to privately owned vehicles parked within the University
        property.</p>

        <h4>Section 6. Authority to Restrict Use of Parking Spaces</h4>
        <p>The University may restrict or otherwise control as necessary,
        the use of parking spaces or lots for University needs and
        special events.</p>

        <h4>Section 7. Prohibition on Overnight Parking</h4>
        <p>Overnight parking is strictly prohibited.Cars may be allowed to
        park overnight at designated overnight parking areas only in
        cases of emergency and official school functions. The
        University is not responsible for any loss or damage to
        vehicles parked overnight inside its premises in cases of
        authorized overnight parking, the driver applicant shall
        execute a waiver of liability to the University for any loss
        or damage fo vehicle parked overnight inside its
        premises</p>

        <h4>Section 7. Prohibition on Overnight Parking (continuation)</h4>
        <p>In cases where overnight parking is allowed, the following
        procedures shall be observed:</p>
        <p>The applicant shall accomplish the Application for Overnight Parking permit (Annex A) and
        submit the same to the concerned office.</p>
        <p>The Vice-President for Administration and Finance (VPAF) for GASS, the Vice-President for
        Academic Affairs (VPAA) for Auxiliary, the Vice-President for Research Development and
        Extension (VPRDE) for East Campus, and the Deans and Directors for external campuses and
        Campus/Cluster Administrative Officers in the main and Daraga campuses are authorized
        to act on the applications for overnight parking permit.</p>
        <p>Once approved, the applicant for overnight parking shall furnish a copy of the approved
        overnight parking to the Guard on duty.</p>
        <p>Guards on Duty must check the overnight parking permit of vehicles parked overnight</p>
        <p>Vehicles must be parked properly and may not occupy two parking slots. Parking in any
        manner which obstructs the free flow of vehicles is prohibited. Ensure that the vehicle is
        parked within the space allotted for one vehicle only.</p>

        <h4>Section 8. Reserved Parking Spaces</h4>
        <p>Parking of motorized and non-motorized vehicles in reserved
        parking areas or spaces is not allowed.For this purpose,
        the Vice-Presidents, Deans and Directors are authorized to
        designate reserved parking areas in their respective jurisdictions.</p>

        <h4>Section 9. Prohibited Parking on Sidewalks and Driveways</h4>
        <p>Parking on sidewalks and driveways is strictly prohibited.
        Violation of this sections shall be penalized in accordance
        with the succeeding sections.</p>

        <h4>Section 10. Vehicle Sticker</h4>
        <p>The University shall issue a vehicle sticker to vehicles authorized
        to enter the University premises. Car stickers shall be issued for
        free to BU employees for one (1) vehicle only for every employee.
        Employees with more than one vehicle shall be required to pay
        the prescribed amount for the additional vehicle/s. Car stickers
        shall be valid for one (1) year only.</p>

        <h4>Section 10. Vehicle Sticker (continuation)</h4>
        <p>Below is the prescribed vehicles sticker fee:</p>
        <p>Applications for vehicle sticker, either for free or for a fee, shall be made at the
        Motorpool Section following the procedures below:</p>
        <p>The applicant shall submit the accomplished Application for Vehicle Sticker (Annex B) together with the
        photocopy of the motor vehicle's Official Receipt (OR)/Certificate of Registration (CR) and owner's driver's
        license to the BU Motorpool Section.</p>
        <p>The Head of the Motorpool Section shall act on the applications for vehicle sticker.</p>
        <p>Once approved, the applicant shall pay the corresponding amount ( applicable) at the University Cashiers
        Office located at the Ricardo A. Arcilla Building (formerly GASS Building) Copy of official receipt shall be
        provided to the Motarpool Section for processing of vehicle sticker.</p>
        <p>The BU Motorpool Section shall then issue the vehicle sticker to the driver applicant.</p>
        <p>The Motorpool Section, Security Services Unit and the Business Affairs Office (BAO) are hereby directed
        to come up with the design of the vehicle sticker.</p>

        <h4>Section 11. Implementation of Traffic Rules and Regulations</h4>
        <p>All parking and traffic rules and regulations will be implemented
        anytime of the day and night.</p>

        <h4>Section 12. Observance of due diligence in driving</h4>
        <p>All drivers are expected to exercise due caution on all parts of
        the University premises with particular regard for the safety of
        all pedestrians.</p>

        <h4>Section 13. University Speed Limit</h4>
        <p>The speed limit in all University roads shall be 15 kilometers per
        hour (kph) Such speed limit shall however be reduced at
        crosswalks, buildings and parking lot entrances and in parking
        lots or other congested areas.</p>

        <h4>Section 14, Driver's Identity Verification</h4>
        <p>Security guards on duty have the authority to verify the identity
        of drivers and their respective vehicles entering the University
        premises A valid Identification Card (I.D.) can be requested
        from the person by the guard on duty when entering the
        University premises</p>

        <h4>Section 15. Loading and Unloading Area</h4>
        <p>The Vice-Presidents, Deans and Directors shall designate
        appropriate loading and unloading areas in their respective
        jurisdictions. Violation of this section shall also be penalized in
        accordance with the succeeding sections.</p>

        <h4>Section 16. Other Guidelines for Driver's Observance.</h4>
        <p>The drivers shall further observed the following guidelines:</p>
        <p>Use of cellular phones while driving is strictly prohibited.</p>
        <p>Driving under the influence of alcohol or drugs is strictly prohibited.</p>
        <p>Drivers must follow all traffic and street signs inside the campus. Alteration, removal
        and defacing any of the signage are prohibited.
        </p>
        <p>Drivers inside the campus must observe all applicable traffic rules and ordinances
        of the Local Government in addition to the rules and regulations of the University.</p>
        <p>Driving, road and pedestrian courtesy must be observed at all times. Threatening or
        verbal abuse of students, fellow drivers, parents, traffic enforcers/security guards,
        or any member of the university community is considered a violation of
        University traffic rules and regulations</p>

        <h4>Section 17. Office tasked fo monitor the implementation</h4>
        <p>The Security Services Unit (SSU) is authorized to strictly enforce
        and monitor the University traffic and parking regulations.</p>

        <h4>Section 18. Towing of illegally parked vehicles</h4>
        <p>Bicol University reserves the right to tow away or impound any
        vehicle parked in violation of University rules and to impose
        such fines as may be specified<br>
        For this purpose and until the University is able to procure its
        own towing equipment, the University shall establish a
        Memorandum of Agreement with the concerned Local
        Government Units which have sufficient towing equipment.<br>
        For colleges/campuses located in LGUs with no towing
        equipment, strict implementation of the penalty provisions
        herein provided shall be observed</p>

        <h4>Section 19. Punishable Acts and Offenses</h4>
        <p>The following are the punishable acts and offenses under
        these guidelines:</p>

        <h5>A. Parking Violations</h5>
        <p>i. Unauthorized parking/overnight parking on campus.<br>
        ii. Parking at a NO parking zone.<br>
        iii, Parking on sidewalk and driveway.<br>
        iv. Parking in reserved areas.<br>
        v. Improperly parked vehicle (ex. double parking, parking occupying two
        lanes, etc.)</p>

        <h5>B. Traffic Violations</h5>
        <p>i. Reckless driving.<br>
        ii. Violation of speed limit.<br>
        iii. Failure to give way to pedestrian on pedestrian lanes.<br>
        iv. Disregarding traffic sign or traffic enforcers/guard on duty.<br>
        v. Obstructing traffic: driving against the traffic or blocking traffic.<br>
        vi. Driving vehicle on sidewalk & pedestrian walkway.</p>

        <h4>Section 19. Punishable Acts and Offenses (continuation)</h4>
        <p>The following are the punishable acts and offenses under
        these guidelines:</p>
        <h5>B. Traffic Violations</h5>
        <p>vii. Loading or unloading at NO loading/unloading zones.<br>
        viii. Driving under the influence of prohibited substances.<br>
        ix. Discourtesy/verbal abuse towards other drivers, students, pedestrians,
        or traffic enforcers/guard on duty.<br>
        x. Vandalism, removal or defacement of street signs.<br>
        xi. Counter flowing.<br>
        xii. Blowing of horns.</p>

        <h5>C. Other Violations</h5>
        <p>i. Fake/altered vehicle sticker.<br>
        ii. Vehicle sticker was used for not for the vehicle it was issued.</p>

        <h4>Section 20. Apprehension of Violators</h4>
        <p>The guard on duty/personnel designated to enforce these parking
        rules and regulation shall hand a violation ticket to the
        driver/person or place a violation ticket (Annex C) on the front
        windshield of all motor vehicles/cycles being cited in violation of
        traffic and parking rules and regulations This will serve as proof of
        legal delivery of the violation ticket. Non-receipt of the parking
        and traffic violation does not invalidate the issuance of the
        violation ticket A photo can be taken by the guard on
        duty/personnel of the violation committed (ex. double parking)
        and violation ticket placed on the vehicle.</p>

        <h4>Section 21. Appeal Process for Issued Violation Ticket</h4>
        <p>Drivers who receive a violation ticket have the right to appeal. The
        written appeal must be submitted to the Office of the Dean/Director
        or VPAF or VPAA where the vehicle is registered within 10 working
        days from issuance of violation ticket.</p>

        <h4>Section 21. Appeal Process for Issued Violation Ticket (continuation)</h4>
        <p>The following information must be included in the appeal.</p>
        <p>(a) Name of Appealing Party<br>
        (b) Reason for appeal<br>
        (c) Plate number of the vehicle<br>
        (d) Copy of violation ticket<br>
        (e) Appealing party's address and contact number<br>
        A copy of the resolution of appeal should be fumished to the SSU/Guard<br>
        an duty for records purposes</p>

        <h4>Section 22. Fines to be imposed in cases of violations.</h4>
        <p>Those issued with violation tickets who opted not to appeal and
        those whose appeal were denied are obligated to pay the
        corresponding fines immediately at the designated Cashier's Office:</p>

        <h4>Section 22. Fines fo be imposed in cases of violations (continuation)</h4>

        <h4>Section 23. Consequence of Failure to Pay Fine</h4>
        <p>A driver-violator who refuses to pay the fines prescribed in these
        guidelines, for the first offense, shall not be allowed to bring their
        vehicles inside the University premises for a period of 2 months;
        and 6 months for the second offense.</p>

        <h4>Section 24. Consequence of Repeated Violations of these Guidelines</h4>
        <p>A driver who violates the provisions of these guidelines for the
        third time shall no longer be allowed to bring their vehicles in
        the University premises.</p>

        <h4>Section 25. Accounting and Utilization of Collected Fines</h4>
        <p>The amount of fines to be collected as a consequence of any
        violation of these guidelines shall be deposited on a trust fund.
        Accumulated amount of fines shall be used exclusively for the
        improvement of motorpool and security services of the
        concerned college/unit.</p>
    </div>
</div>

</div>
</body>
@endsection
