<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Zestlog</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css?id=').version()}}">
    <link rel="stylesheet" href="{{asset('css/custom.css?id=').version()}}">
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
</head>

<body>
<!-- <div class="flex-center position-ref full-height">
       @if (Route::has('login'))
    <div class="top-right links">
@auth
        <a href="{{ url('/home') }}">Home</a>
            @else
        <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
    @endauth
        </div>
        @endif


    </div> -->

<div class="home-wrapper static-content" style="background-image: url('/assets/images/home-bg.png');">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 m-auto">
                    <div class="card mt-5 mb-80">
                        <div class="card-body">
                                <h1>Zestlog Privacy Policy</h1>
                                <ol>
                                    <h1><li>Protecting Your Privacy</li></h1>
                                    <p>Central to our mission to make the world a better place is our commitment to be transparent about the data we collect, and how it is used and processed. By “data” we generally mean any information or Content on or through our Services, or the information we may receive from third parties. By agreeing to our Terms of Service and this Privacy Policy, you grant us a legal permission to collect, use and process any data that belongs to, is related to, or is about you (collectively, your “Data”) according to the Terms of Service and this Privacy Policy (the “Policy”).<br><br> This Privacy Policy is designed to inform you about your rights in conjunction with your access to and use of our Services and describes how we collect, use, process, and disclose your Data.
                                        <br><br>This Privacy Policy is an integral part of our Terms of Service. You are therefore responsible to carefully read both our Terms of Service and this Privacy Policy. Undefined terms herein have the same definitions as in our Terms of Service.
                                    </p>
                                    <h2>1.1 Data Controller</h2>
                                    <p>When this Policy mentions “Zestlog”, “we”, “us”, or “our”, it refers to Zestlog LTD, a London based company registered in the UK with company number 12963990 and company address at 27 Old Gloucester Street, London, United Kingdom.</p>
                                    <h2>1.2 Where This Policy Applies</h2><p>This Privacy Policy applies to all Services, as defined in the Terms of Service, provided to you by Zestlog.</p>
                                    <h1><li>Data We Collect</li></h1><p>To provide our Services, we may collect and process certain Data. The types of Data we collect depend on how you use our Services. This section describes what types of Data we collect.</p>
                                    <h2>2.1 Data We Collect When You Use Our Services</h2><p>When you access or use our Services, we may collect certain types of Data, for example, the Data required for account registration, and Content such as the Content you create, upload, store, share, communicate, or make available on or through our Services. </p>
                                    <h2>2.1.1 Account</h2>
                                    <p>You don’t have to create an account to access part of our Services such as accessing our website. If you do choose to create an account and become a registered Member, you must provide us with some Data so that we can provide our Services to you. To create a personal account you may need to provide the following Data:</p>
                                    <ul>
                                        <li>Your First name and your last name; which are always visible publicly</li>
                                        <li>Your birthdate; which by default is not visible publicly. In addition, for the purpose of personalization, your age may become visible to your personal coach.</li>
                                        <li>Your mobile number; which by default is not visible publicly</li>
                                        <li>Your password; which by default is not visible publicly</li>
                                    </ul>
                                    <p>When you create your account and complete signup, a unique username is automatically generated for you. You can choose to make your username publicly visible so that it will be easier for people to search and find your profile on Zestlog. <br>
                                        As our services is not directed towards children, we use your birthdate during sign-up to ensure you are 13 years old or older. Please read our Terms of Service carefully about age requirements.</p>
                                    <p>We use your phone number to authenticate your account, keep your account secure, and to help prevent spam, fraud, and abuse. We also use your contact information (i) to enable certain account features (for example, for login verification via SMS), (ii) to send you notifications and information about our Services and other information that may be of use to you, and (iii) to help others find your Social Profile, if your Settings permit, through third-party services. If you wish, you can unsubscribe from a notification by using your Settings to control notifications you receive from us.<br><br>
                                        In addition to the first group of Data mentioned above that is required for account registration, you may also provide a second group of Data including:
                                    </p>
                                    <ul>
                                        <li>Your general health and fitness goal; which is not visible to other Members </li><li>Your gender selection; which is not visible to other Members</li>
                                        <li>Your body weight; which is not visible to other Members</li>
                                        <li>Your height; which is not visible to other Members</li>
                                    </ul>
                                    <p>With the second group of data provided during account registration, our health related applications will be automatically personalized to you upon your first login. <br><br>
                                        You can control, manager, and update your account in your Account Settings. Account Settings may include various settings such as Profile settings, Privacy settings, Security settings, App related settings, etc. We collect, store and process your Data and settings in and related to your Account.</p>
                                    <h2>2.1.2 Profile</h2>
                                    <p>As a registered Member, you have a profile where you control and manage your online social presence and activities (hereafter your “Profile”). To properly operate various features related to your Profile, we collect, store and process your Data on and related to your Profile.<br><br>
                                        If your identity is verified by us, an “Identity Verified” icon may appear publicly on your profile. Identity verification is a feature we use to verify that you are the person you say you are. You can choose to request us to verify your identity. To be able to verify your identity, we collect, store, and process your Data related to your identity. In some cases we may need to receive help from third parties to verify your identity. We emphasize that as long as we have not requested you to provide a government-issued ID, the identity verification is totally optional and you can choose to skip it.</p>
                                    <h2>2.1.3 Channel</h2>
                                    <p>You as a Member can activate your channel and become a SP (Service Provider) on our Services. When you activate your channel, we will display your channel publicly so that Members can view your channel and potentially become your paying clients. Your channel may display certain information publicly such as your resume, availability, Listings, and ratings and reviews which have been made available by your current and past clients. To operate your channel related features on the Services we collect, store and process your Data on and related to your channel.</p>
                                    <h2>2.1.4 Content</h2>
                                    <p>To make your Content accessible to you and to whom you choose to share your Content with, we collect, store and process your Content. This includes the Content made available by you or related to you such as your public and non-public Data on your Profile, your health and fitness data, and your public and non-public communications with other Members. How we handle your Content depends on how you use our Services. More details and applicable Terms related to how we may process and use your Content are available on our Terms of Service.</p>
                                    <h2>2.1.5 Connections</h2><p>To properly operate various features of our Services we may collect certain information about the people, accounts, hashtags, groups, etc. you are connected to and your interactions with them on our Services which we use to improve your experience on the Services and recommend more personalized Contents to you.</p>
                                    <h2>2.1.6 Address Book</h2><p>We may collect contact information if you choose to sync, upload or import your address book from a device to your account or allow your account to access your address book so that we can help you find and connect with people you may know and help others find and connect with you. We may also use this information to better recommend content to you and others.</p>
                                    <h2>2.1.7 Log Data</h2><p>We log information about how you access, use or interact with our Services, which we refer to as “Log Data”. For example, we log information about devices that you use for connecting to our Services, such as information you allow us to receive through your device Settings (such as access to your GPS location, camera and photos), information about your device network and net connections, and some other types of usage and device related information such as pages visited, location, IP addresses, browser type, operating system, mobile carrier, device identifiers, and cookie information. The Log Data may also include information about how our Services are used, for example the features you use, the time, frequency and duration of your activities, and other activities happening on your account.</p>
                                    <h2>2.1.8 Cookies</h2><p>We use cookies and similar technologies such as web beacons, pixels, mobile identifiers, and tracking URLs (Collectively, “Cookies”) to collect additional data about your usage of our Services in order to better understand how you interact with our Services, personalize and otherwise improve both your experience and the operation of our Services. A “cookie” is a unique piece of data that is transferred to and stored in your device to perform important functions such as authentication purposes, for example, to know the user’s logging in activities, and which account they are logged in with, and to track, for example, user’s interests, preferences and actions on our Services or on the third-party services we use. Cookies are not required for the operation of many parts of our Services, however, some parts of our Services may not function in full capacity if you disable Cookies.</p>
                                    <h2>2.1.9 Payment Information</h2><p>We may collect payment information such as credit or debit card number, card expiration date, CVV code, and information about transactions made on our Services such as name of parties involved in a transaction, billing information, and other transaction related information.</p>
                                    <h1><li>How We Use Collected Data</li></h1><p>How we use the Data we collect depends on which Services you use, how you use those Services and the choices you make in your Account Settings. We may use and process your Data as described below.</p>
                                    <h2>3.1 General Services<br>3.1.1 Access to Our Services</h2>
                                    <p>We use your Data to authorize your access to our Services. For example, you may need to use your phone number, or username, and password in order to log in to your account and be able to use our Services. We also use your Data to operate your account. This includes making your account and account-related features accessible to you. It also includes making your Profile accessible to other Members.<br><br>If you use our Services, not as a registered Member, but as a Visitor to one of our Sites, we use your Data such as your location to produce aggregated insights and statistics about how our Services are used.</p>
                                    <h2>3.1.2 Stay Connected</h2><p>We use your Data (such as your name, your username, your Profile picture, or data provided through address books) to help others find your Profile and to allow you to connect with other Members. For example, you can find Members you know, follow their Profiles and send them direct message, and other Members can find and follow your Profile and send you direct message as well. Our Services allow you to block a Member or Members if you choose to do so. Your Profile and your Content is not visible to a blocked Member. You can unblock previously blocked members at any time if you choose to do so. </p>
                                    <h2>3.1.3 Stay Informed</h2><p>By connecting to other Members, and to our Services generally, you can stay up to date with latest Contents available on our Services. Our Services allow you to improve your health and fitness by learning tips and advice from health specialists that you respect. Our Services also allow you to stay informed about news, events and Contents that may interest or motivate you.</p>
                                    <h2>3.1.4 Personalization</h2><p>We use your Data to personalize our Services to you. For example, we use your age, gender, height, and body weight to calculate your recommended daily caloric intake. We use your training age and your fitness goal to recommend you more suitable training programs. </p>
                                    <h2>3.1.5 Health & Fitness Data Storage & Progress Analysis</h2><p>We enable you to record and store your health and fitness related data and use our Services as a storage of such data. In addition, we may use your stored data to provide you with additional features, such as various graphs or charts, which enable you to perform progress analysis. Your health and fitness related data may include your physical and physiological health data and nutritional and training data. </p>
                                    <h2>3.1.6 Improve Your Experience</h2><p>Based on the Data about your interaction with our Services, we may recommend you, or display to you, more relevant Contents on our Services. For example, we use Data about which Members you follow and your geographical location to display Contents that may be closest to your preferences.</p>
                                    <h2>3.2 Services Related to Our Marketplace</h2>
                                    <h2>3.2.1 If you act as a SR (Service Receiver)</h2><p>You can use our Services to search, find, and hire or book your personal health & fitness coach (Service Provider or “SP”). During the booking process, we collect and share certain Data with the SP you intend to hire in order for the SP to decide whether he or she is able to provide the services you intend to receive. If your booking is accepted, we will then use the Data provided on the booking form to further personalize the services you receive. Your SP may then be able to monitor your progress and your activities related to the services you receive through various features we provide. We also use your payment related information to enable you to make payment and complete your bookings. </p>
                                    <h2>3.2.2 If you act as a SP (Service Provider)</h2><p>If you activate your channel and become a SP on our Services, we use your Data to display your Listings, attract Members to your channel and help you turn these potential clients to your paying clients. Using our Services, we make it possible for you to receive bookings containing certain clients’ data that you may need in order to prepare and deliver your services. We use your Data to make all these Services available. </p>
                                    <h2>3.3 Research, Development & Aggregated Insights</h2><p>We may use and process the Data we collect for legitimate reasons, for example producing aggregated insights and statistics about our Members and Visitors, their health and fitness conditions, and their usage pattern. We use such Data for improving our existing Services and conducting research to innovate and develop new Services, and for Social good.</p>
                                    <h2>3.4 Safety & Security</h2><p>We may use and process the Data we collect if we think it’s necessary for security purposes, for example, to guard against or prevent fraudulent, illegal, harmful or inappropriate conduct or other bad experiences, and ensure that our Services remain safe and secure. We may use Data to detect if someone needs help and investigate suspicious activities or violations of our Terms or Policies. We may use Data to ensure transactions made on our Services are made safely and securely.</p>
                                    <h2>3.5 Communication & Support</h2><p>We may use your contact information including your mobile number and email address to communicate with you about available news and events, interesting Contents, new features, and other Service related communications. We may use your Data when you contact us for support or resolving Service related issues.</p>
                                    <h2>3.6 Legal Obligations</h2><p>We use and process the Data we collect whenever applicable law requires us to do so.</p>
                                    <h1><li>Sharing & Privacy Choices</li></h1>
                                    <h2>4.1 Our Services</h2>
                                    <h2>4.1.1 Your Profile</h2><p>As a registered Member, in your account Settings there is a profile section, which is private to you, where you can change or update certain information such as first name, last name, username, phone number, birthdate, gender, height, current body weight, waist circumference, and general health and fitness goal. Of the personal information mentioned above, your first name, your last name, and your username are by default public. In addition, during booking a SP, we may share some of your health and fitness data with the SP you intend to hire.</p>
                                    <p>There is also a section on the Services where you find your public Profile. How we share your Profile and its Privacy depend mostly on how you use our Services. As a registered Member, your Profile including your first name, your last name, your username, and the information you choose to add to it including your profile picture and opening statement (your bio) are public. The public information displayed on your Profile is your most recent update. Members can search, find and follow your Profile, but, Members who are blocked by you cannot find or follow your Profile.<br><br>Although by default your Profile is public, you have full control over the privacy of your logs that you share on your Profile. You can set the privacy of your logs to one of the following privacy options:</p>
                                    <ul>
                                        <li><b>Public:</b> All Members whom you have not blocked can view your “Public” logs. </li>
                                        <li><b>Only followers:</b> Any Member who is following your Profile can view logs set to “Only followers”</li>
                                        <li><b>Only me:</b> Only you can view logs with “Only me” privacy. </li>
                                    </ul>
                                    <p>As described in detail on the Terms of Service, you are alone responsible for your Content that you share with the public through our Services. For example, it is possible for other Members to make screenshots and screen-records of your public images and videos using certain applications/tools on their devices, over which we have no control, therefore, you should think carefully about what you make public.<br>We may also display the Data that you choose to share with the public on other websites, apps, or in emails.</p>
                                    <h2>4.1.2 Your Channel</h2><p>As a registered Member, if you act as a SP on the Services and successfully activate your channel, your channel will appear publicly where members can view certain information such as your resume, availability, Listings, and ratings and reviews made available by your past and current clients. You have full control over the information you provide on your resume, availability, Listings by changing or updating such information. </p>
                                    <h2>4.1.3 Your Content</h2><p>How we handle your Content depends on how you use our Services. The Privacy of your Content on or through our Services can be categorized into the following groups:</p>
                                    <p>(i) Contents that is shared with public<br><br>Your first name, last name and username on your Profile, and your Content available on your channel (if available) are displayed publicly. If you choose to add a profile picture and an opening statement to your Profile, those information will also be public. You can block any Member so they cannot find and view your Profile and channel. </p>
                                    <p>(ii) Contents that can be shared with public<br><br>You can set the privacy of your logs on your Profile to “Public”, by that, your logs will be displayed publicly. </p>
                                    <p>(iii) Contents that can be shared with specific Members<br><br>You can set the privacy of your logs on your Profile to “Only followers”, by that, your logs will be displayed only to your followers. </p>
                                    <p>Furthermore, for a non-public communication you may use direct messaging that allows you control who sees your Content when you communicate with other Members. By communicating your Content with a Member or a group of Members using direct messaging in a non-public communication, you share your Content with that Member or group of Members.</p>
                                    <p>(iv) Contents that may be shared with your SP</p><p>When you hire or book a SP through Zestlog marketplace some of your health related Data, for example your progress in health and fitness and your physical exercise and nutritional records and tracking, may be shared with your SP. As a health specialist, your SP may need to monitor your health related Data in order to better guide you and personalize his or her services to you. </p>
                                    <p>(v) Contents that are not shared with other Members</p><p>Any Content that is not part of the first four groups discussed above, is not shared with other Members and remain fully private, for example your payment settings and bills, and your self-service related data.</p>
                                    <h2>4.1.4 Cookies</h2><p>In many cases you can manage Cookies preferences and decline having Cookies by changing the Settings on your browser. Different browsers may be different in changing Settings, therefore, you should visit the Help section of your browser to learn about Cookies preferences that may be available to you. For Cookies that cannot be managed by using the browser Settings, for example flash cookies, you can visit the Help section on the websites of the providers of such technologies, in the case of flash cookies visit Adobe website. Your mobile device may also allow you to manage Cookies. Visit your device manufacturer’s instructions for more information. You understand that if you choose to remove or decline Cookies, this may affect the features, availability, and functionality of our Services.</p>
                                    <h2>4.2 Third-Party Service Providers</h2><p>We use others to provide us with services we require for the operation, maintenance, monitoring and analysis of our Services, for example, hosting services, analytical services, and payment processing services. We may share your Data with such third-party service providers. We try to take appropriate confidentiality and security measures on the condition that the third parties use your Data only according to the intended purposes.</p>
                                    <h2>4.3 Non-Personal Data</h2><p>By non-personal data we mean data in aggregated form that does not identify Members or Visitors individually. We may share or disclose non-personal data publicly, such as aggregated insights and statistics about Members & Visitors, their health and fitness conditions, and their usage patterns.</p>
                                    <h2>4.4 Legal Obligations, Safety and Security</h2><p>We preserve rights to use or disclose your Data if we believe that such a use or disclosure is necessary (i) to comply with a law, legal process, or upon request from authorities (ii) to protect the safety of any person (iii) to protect the safety, security or integrity of our Services (iv) to protect our rights or property, or to protect the rights or property of our Members, or (v) to explain why we have taken any action, such as closing an account, on our Services. </p>
                                    <h2>4.5 Change of Control or Ownership</h2><p>In the event or in preparation for such events that we are involved in a merger, acquisition, reorganization, or similar transactions, your personal data may be transferred as part of that transaction. In such event, this Privacy Policy will apply to your personal data when transferred to the new entity.</p>
                                    <h2>4.6 Risk Involved</h2><p>By implementing technical and organizational measures, we ensure, to our best ability, that your Data is processed safely and securely. We regularly monitor our Services for possible vulnerabilities and attacks, and continuously try to improve safety and security of our Services. However, we cannot guarantee zero risk to your Data. Some risk may be involved to your Data when using a digital platform on the internet. It is important that you inform us immediately if you suspect you have been a victim of an attack on your Data. In such events, you can contact us using one of the methods specified below.</p>
                                    <h2>4.7 Children</h2><p>Our Services are not directed to children. We do not knowingly allow children under the Minimum age to use our Services without the permission of their legal representative. If you are a parent, or a legal representative of a child, and become aware that your child uses our Services without your permission, please contact us immediately using one of the methods specified below, and we will closely work with you to address this issue. Children under the age of 13 are not allowed to use our Services.</p>
                                    <h1><li>Your Rights, Choices & Data Retention</li></h1>
                                    <p>You have the right to access your Data at any time while you have a registered account on our Services. You may correct, update or delete your Data.<br><br>You have the right to stop accessing or using our Services, or refuse to accept our Terms of Service and Privacy Policy, by closing (deleting) your account, as described in our Terms of Service under Terms of Termination, and discontinuing your access to or use of our Services. We collect, use and process your Data on the basis of your consent to the Contract, the Terms of Service and this Privacy Policy, and you can withdraw your consent at any time by permanently deleting your account. </p>
                                    <p>After you have permanently closed your account, your account and your Profile will stop being visible to other Members on our Services and publicly outside our Services within a short period of time, however, we cannot guarantee to remove all your past activities on our Services as well as your Data previously shared with third parties. We may retain your Data after you have closed your account if we are permitted, or required, by law. This data retention may be necessary (i) to comply with our legal obligations; for example, recordings of consent to our Terms of Service, and Privacy Policy, (ii) to resolve an unresolved disputes, claim or issue (iii) to prevent fraud, improve safety, or in other legitimate interests of Zestlog; for example, we may retain certain Data in order to prevent a prohibited person from registering a new account due to their inappropriate conducts in the past.
                                        We may close an account that has not been logged in for a certain period of time since the last time it has been logged in, however, as an alternative, you can send us instructions on how your account and its Data should be handled, used or deleted after you die by sending us an instruction to the email address “termsofservice@zestlog.com”. If you send us such instructions, you may be required to provide us with additional documentations. You understand that sending such instructions does not guarantee you an unlimited right and it must be exercised according to the conditions of current laws. You also understand that at our best effort we may be unable, and therefore cannot guarantee, to execute your instructions.</p>
                                    <h1><li>Changes</li></h1>
                                    <p>We reserve right to revise our Terms of Service and Privacy Policy at any time. If we revise our Terms of Service and Privacy Policy, we will publish the revised version on our Services. The changes cannot be retroactive, and the most current version of Terms of Service and Privacy Policy, which will always be available at www.zestlog.com, will govern our relationship with you. If you object to any revisions, you can send your objection by contacting us via the email address “termsofservice@zestlog.com” and wait for a response from us before you resume your use of our Services, or you may close your account and stop accessing and using our Services entirely.
                                        We try to notify you of the revisions through our Services, or by other means, so you will have the opportunity to review the changes, however, your continued access to or use of our Services after we made the new revisions publicly available means that you are consenting to the most updated Contract, Terms of Service and Privacy Policy.</p>
                                    <h1><li>How to Contact Us</li></h1>
                                </ol>
                                <ul>
                                    <p>The email addresses below are designed for the following purposes.</p>
                                    <li>For general inquiries, please contact “contact@zestlog.com”</li>
                                    <li>For reporting content or accounts, please contact “report@zestlog.com”</li>
                                    <li>For reporting an unauthorized access to your account, please contact “unauthorizedaccess@zestlog.com”.</li>
                                    <li>For closing account, please contact “accounttermination@zestlog.com”</li>
                                    <li>For inquiries related to Terms of Service or Privacy Policy, please contact “termsofservice@zestlog.com”.</li>
                                    <p>In the cases which you have not received any reply to the email(s) you have sent to us, you may need to write to us at the following postal address: Zestlog LTD, 27 Old Gloucester Street, London, United Kingdom.</p>
                                </ul><br><br>
                        </div>
                    </div>
            </div>
            @include('layouts.home-footer')
        </div>
    </div>
</div>


<!-- Forgot password modal -->
<div class="modal fade" id="forgot-pass-modal" tabindex="-1" aria-labelledby="forgot-pass-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="hp-modal modal-content">
            <div class="modal-header border-0 p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-5">
                <h3 class="fw-600 mb-4">Forgot your password?</h3>
                <p class="text-dark mb-0 fw-600">Please use our mobile app to change your password.</p>
                <span class="text-muted">You can find "Forgot Password" on the app login page.</span>
            </div>

        </div>
    </div>
</div>

<!-- Become a coach modal -->
<div class="modal fade" id="hw-coach-modal" tabindex="-1" aria-labelledby="hw-coach-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="hp-modal modal-content">
            <div class="modal-header border-0 p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-5 px-4">
                <h3 class="fw-600 mb-4">How to become a Fitness Coach on Zestlog</h3>
                <p class="text-dark mb-0 fw-600">On your mobile.</p>
                <ol>
                    <li class="text-muted">Download <a href="#!">Zestlog app</a> and create your Zestlog account <br> <small>(Currently only Android App is available)</small></li>
                    <li class="text-muted">Activate <a href="#!"> your coach channel</a> in your account setting</li>
                </ol>

                <p class="text-dark mb-0 fw-600">On the web <small class="fw-600">(at www.zestlog.com)</small></p>
                <ol>
                    <li class="text-muted">Enter your phone number & password and press log in <br> <small>(same phone number & password as you use for our mobile app)</small></li>

                </ol>

            </div>

        </div>
    </div>
</div>

<!-- Join modal -->
<div class="modal fade" id="join-modal" tabindex="-1" aria-labelledby="join-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="hp-modal modal-content">
            <div class="modal-header border-0 p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-5">
                <h3 class="fw-600 mb-4">Joining Zestlog community?</h3>
                <p class="text-dark mb-0 fw-600">Please create your account on our mobile app.</p>
                <span class="text-muted">Download <a target="_blank" href="https://play.google.com/store/apps/details?id=com.imark.zestlog">Zestlog app</a> and create your Zestlog account <br><small>(Currently only Android app is available)</small></span>
            </div>

        </div>
    </div>
</div>
@include('layouts.footer')
</body>
<script>
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
</html>




