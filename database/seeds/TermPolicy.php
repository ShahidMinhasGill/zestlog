<?php

use Illuminate\Database\Seeder;

use App\Models\TermsAndPolicy;

class TermPolicy extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $html = '<h1>Terms of Service</h1>
                        <p>Please read these Terms of Service (“Terms”) carefully as they contain important information about your legal
                            rights, obligations and remedies. By accessing or using Zestlog Services (as defined below), you agree to
                            comply with and be bound by these Terms.</p>
                        <h2>Welcome to Zestlog</h2>
                        <p>These Terms stated herein constitute a legally binding contract (the “Contract”) between you and Zestlog (as
                            defined below) governing your access to or use of Zestlog Services and all Contents (as defined below) on or
                            through the Services. </p>
                        <p>The Zestlog Services include:</p>
                        <ol type="i">
                            <li>Zestlog mobile, tablet and other smart device applications, Zestlog application program interfaces, and
                                Zestlog web applications (collectively, "Application")
                            </li>
                            <p>
                            <li>Zestlog website, including any subdomains thereof, and any other websites through which Zestlog makes
                                its services available (collectively, "Site")
                            </li>
                            </p>
                            <p>
                            <li>All associated Zestlog services (collectively, “Associated Services”)</li>
                            </p>
                        </ol>
                        <p>These three including Applications, Sites and Associated Services together are hereinafter collectively
                            referred to the Zestlog Services (for short, the “Services”). </p>
                        <p>The Content includes any information, data, text, links, graphics, photos, audio, videos, or other materials
                            or arrangements of materials created, entered, made available, uploaded, downloaded, obtained from,
                            communicated, shared or appearing on or through the Services (hereinafter, the “Content”). </p>
                        <p>When these Terms mention “Zestlog”, “we”, “us”, or “our”, it refers to Zestlog LTD registered in the UK with
                            company number 12963990 and company address at 27 Old Gloucester Street, London, United Kingdom.</p>
                        <ol>
                            <h1>
                                <li>Contract</li>
                            </h1>
                            <p>By creating or registering a “Zestlog account” (hereinafter “account”), clicking or tapping “Sign Up”,
                                “Join” or similar, accessing or using the Services, you agree and accept to enter into a legally binding
                                contract (the “Contract”) with Zestlog. The Terms of Service stated herein are to be the terms of the
                                Contract. If you do not agree to this Contract, do not create an account and do not access or otherwise
                                use any of our Services. If you wish to terminate this contract, you can do so at any time by
                                permanently closing (also known as deleting) your account and discontinuing your access to or use of our
                                Services. For more details regarding account termination, please read Terms of Termination section
                                below. </p>
                            <h1>
                                <li>Members</li>
                            </h1>
                            <p>When you create or register an account on our Services, you become a Zestlog registered user (a
                                “Member”). If you have chosen not to create or register an account, you may access certain features of
                                our Services as a visitor<br> (a “Visitor”).</p>
                            <h1>
                                <li>The Scope of the Zestlog Services</li>
                            </h1>
                            <p>The Services we provide are to advance Zestlog’s mission: To make the world a better place by helping you
                                improve your health, wellness and fitness, and enabling you to help others to improve their health,
                                wellness, and fitness, so that together, we build a healthier and happier society. Our mission may be
                                accomplished by:</p>
                            <ul>
                                <li>Personalizing our Services to you, your needs and your interests, whether through nutrition,
                                    physical exercise, coaching, or social and business networking.
                                </li>
                                <li>Creating a community of zestful people and connecting you with people and organizations who can help
                                    you, who interest you, and whom you can help
                                </li>
                                <li>Protecting you from unethical, or professionally uneducated people or organizations who may mislead,
                                    misguide, or take advantage of you
                                </li>
                            </ul>
                            <h1>
                                <li>Privacy Policy</li>
                            </h1>
                            <p>Providing our Services requires collecting, using and processing certain types of data. Our Privacy
                                Policy describes<i> how we collect, use, process and share your personal data.</i> Our Privacy Policy is
                                an integral part of our Terms of Service. You are therefore responsible to carefully read both our Terms
                                of Service and Privacy Policy. You can also go to your Account Settings at any time to review or update
                                the privacy and security choices you have. You understand that by accessing or using our Services you
                                consent to and accept our Privacy Policy.</p>
                            <p>Undefined terms herein have the same definitions as in our Privacy Policy.</p>
                            <h1>
                                <li>Use of the Services</li>
                            </h1>
                            <h2>5.1 Who May Use Our Services</h2>
                            <p>You are not allowed to access or use our Services unless you accept our Terms of Service stated herein
                                and consent to our privacy policies stated in our Privacy Policy.</p>
                            <p>To use our Services, you must be the minimum age or older. In many countries, the minimum age is 16
                                (sixteen) years old. However, the laws applicable to the minimum age may vary country by country, and in
                                some cases state by state within a country. Therefore, it is your sole responsibility to ensure that you
                                are the minimum age or older specified by applicable laws in your state (or country). If you are under
                                the minimum age, you are not allowed to use the Services without the permission of your legal
                                representative. Your access to the Services may be denied without warning if we believe that you are
                                under the minimum age and have not obtained verifiable consent from your legal representative. If you
                                are a parent or a legal representative and you provide your consent to your child’s use of our Services,
                                you agree to be bound by this Contract in respect to your child’s use of the Services. Furthermore, our
                                services are not directed to children, and you are not allowed to use our Services if you are under the
                                age of 13 (thirteen).</p>
                            <p>If you are creating an account on behalf of a legal entity, the legal entity which you are acting on
                                behalf of must be a validly, lawful, existing legal entity under the laws of the country it is
                                established or registered, and able to enter into this legally binding Contract. </p>
                            <p>We retain the right to prohibit your access to or use of our Services at any time without prior notice in
                                case we find this action appropriate. We may, at our discretion, stop providing the Services to you,
                                suspend or terminate your account whether permanently or temporarily if we find such action appropriate.
                                We reserve the right to create limits on the amount of use of the Services and the storage of your
                                Content at our sole discretion at any time. We also reserve right to change or delete your username or
                                similar identifier for your account if we believe it is appropriate or necessary to do so. </p>
                            <p>We must not have disabled your account in the past for violation of law or any of our Terms, Policies or
                                Guidelines. You must not be prohibited from receiving any of our Services under applicable laws. </p>
                            <p>You are not allowed to buy, sell, or transfer any aspect of your account or the right we grant you to
                                access and use the Services.</p>
                            <p>You agree not to create accounts, access or use our Services, or collect information on or through our
                                Services in illegal, unlawful, or inappropriate ways.</p>
                            <h2>5.2 Using the Services</h2>
                            <p>We try to provide you with the best Services that we can provide and keep the Services reliable,
                                functional, safe, and secure, however, you understand that our Services may not always function without
                                delays, disruptions, errors, bugs, or imperfections and it may stop functioning completely. You agree
                                that in the cases of any imperfections or if the Services shut down completely, we cannot be held
                                responsible and will not have any liability to you or Members and Visitors generally. </p>
                            <p>We have a clear intention to provide the world with the Services that we believe can help to build a
                                healthier, happier and safer world. However,<i> we cannot guarantee a complete accuracy, reliability or
                                    suitability of our Services and the Content on or through the Services.</i> We cannot be held
                                responsible and will not accept any liability for death, damage, or personal injuries in connection with
                                the use of our Services whether caused by the misuse of the Services, our<i>negligence in ensuring the
                                    accuracy of the Services, or false, inaccurate information, instructions or Content available on or
                                    through the Services. You must understand that the Services and the Content are not meant to replace
                                    the care and support provided by registered health or medical professionals. You should not use the
                                    Services and the Content to self-diagnose or to replace the medical support of professionals and we
                                    strongly recommend you not to do so.</i></p>
                            <p>In connection with accessing or using the Services, you must not do what you are not allowed to do on or
                                through our Services. You are not allowed (i) to misuse the Services by violating our Terms, Policies
                                and Guidelines or applicable laws and regulations, (ii) to use the Services for anything unlawful,
                                misleading or for such purposes, (iii) to do anything that may impair or interfere with the intended
                                operation of the Services, (iv) to impersonate a person whom you are not, or (v) to share or post
                                private or confidential information or do anything that violates someone else\'s rights on and through
                                the Services.</p>
                            <p>You agree that Zestlog has no obligation to monitor the access to or use of the Services by any Member or
                                to review, monitor, delete or edit any Members’ Content, but has the right to do so in order to (i)
                                operate, secure and improve the Services for, including but not limited to, fraud prevention, risk
                                assessment, investigation or customer support purposes; (ii) ensure Members’ compliance with these
                                Terms; (iii) comply with applicable law or the order or requirement of a court, law or other
                                governmental authorities; (iv) respond to Members’ Content that Zestlog determines to be harmful,
                                offensive or objectionable; or (v) as otherwise set forth in these Terms. </p>
                            <p>We reserve right to make access to our Services, or certain areas or features of the Services such as
                                completing a verification process, monitoring specific quality or eligibility criteria, monitoring
                                ratings or reviews, and monitoring a Member’s booking and cancellation history.</p>
                            <p>We may periodically delete inactive accounts. If an account has not been logged in for a certain period
                                of time, we reserve right to delete such an account without prior notice. </p>
                            <h2>5.3 Your Account Security Guidelines</h2>
                            <p>In order to access or use some of our Services, you may need to create an account. As our security
                                guidelines (i) you are responsible for safeguarding your account by using a strong password, (ii) you
                                may use a device or a number of devices to access or use our Services, and it is your responsibility to
                                keep such devices safe and ensure you always log out of your Zestlog account if there is a possibility
                                of unapproved, unauthorized access to your account, (iii) you must immediately notify Zestlog if you
                                know or have any reason to suspect that your credentials have been lost, stolen, misused, or otherwise
                                compromised or in the case of any actual or suspected unauthorized use of your account, and (iv) you
                                understand that Zestlog does not authorize any third party to ask for your credentials, and you are not
                                allowed to request the credentials of another Member.</p>
                            <p>We cannot be held responsible and will not be liable for any loss or damage caused by your failure to
                                comply with our security guidelines stated herein. </p>
                            <p>You are liable for any and all activities conducted through your account, unless you have reported (as
                                instructed below) an unauthorized access to your account. You can report such incidents by sending email
                                to “unauthorizedaccess@zestlog.com”.</p>
                            <h1>
                                <li>Content</li>
                            </h1>
                            <p>You are responsible for anything that happens on or through your account unless you close it or report to
                                us an unauthorized access to or misuse of your account. You are responsible for your use of the Services
                                and for any Content you make available, including compliance with applicable laws, rules, and
                                regulations. You understand that the Content you delete from your account may persist for a limited or
                                unlimited period of time in backup copies and may still be visible where others have shared it. Making
                                Content available on or through the Services includes creating, sharing, logging, posting, displaying,
                                storing, sending, and providing Content on or through the Services.</p>
                            <p>We do not approve, support, or guarantee the reliability, accuracy, or trustworthiness of any Content
                                made available via the Services. We may not control or monitor the Content made available on or through
                                the Services and we do not take responsibility for such Content. You understand that by using the
                                Services, you may be exposed to Content that might be harmful, offensive, false, wrong, misleading,
                                misguiding, inaccurate or otherwise inappropriate. For all such Content, it is the sole responsibility
                                of the person who has made such Content available, and the use or application of such Contents are at
                                your own risk.</p>
                            <p>We do not claim any ownership rights in any of the Members-generated Content, however, we require you to
                                grant us a license that authorizes us to make your Content available Worldwide. You acknowledge and
                                agree that by creating, uploading, logging, posting, sending, receiving, storing, displaying, or
                                otherwise making available any Content on or through the Services, you grant Zestlog a worldwide,
                                non-exclusive, royalty-free, irrevocable, perpetual, sub-licensable and transferable license to display,
                                distribute, reproduce, modify, process, copy, publish, transmit, stream, broadcast, and otherwise use
                                such Content in any or all media, platforms or distribution methods, now known or later developed. You
                                acknowledge and agree that such license that you grant Zestlog is made with no compensation paid to you
                                and you are not entitled to any compensation for making Content available on or through the Services.
                                You represent and warrant that you have, or have obtained, all rights, licenses, consents, permissions,
                                power or authority necessary to grant such license to Zestlog for any Content that you make available on
                                or through the Services.</p>
                            <p>We may, at our discretion or required by law, remove or refuse to distribute any Content or information
                                on and through the Services without any liability to you or Members and Visitors generally. We reserve
                                the right to remove any Content that violates our Policies and Guidelines without a prior notice. </p>
                            <h1>
                                <li>Provisions Related to Zestlog Marketplace</li>
                            </h1>
                            <p>Zestlog provides its Members with, among others, a Service commonly known as online (or digital)
                                marketplace. As a Member, if you wish to enter into a transaction in the online marketplace that Zestlog
                                provides to its Members, you may act either as a receiver of a service (the “Service Receiver”,
                                abbreviated to the “SR”) or as a provider of a service (the “Service Provider”, abbreviated to the
                                “SP”).<br> Examples of SPs may include health professionals, fitness professionals, medical
                                professionals, caregivers, and any type of health clubs. Examples of SRs are Members who are seeking to
                                receive health, fitness, medical or care related services (“Health Services”). </p>
                            <p>The Zestlog online marketplace (the “Zestlog Marketplace”) enables SPs to list the services they provide
                             (“Listings”) on the Zestlog Marketplace and to communicate with Members that are seeking to receive such
                              services. A SR may search through the list of SPs and select one as his or her SP. The SR may then complete
                               and submit a booking request through the Zestlog Services. The SP may receive and accept the booking request
                                through the Services. Upon the SP booking confirmation (or acceptance) a legally binding contract is made
                                 between the SP and the SR. We may or may not process the payments and fees associated with bookings.
                                  If we do not process the payments and fees associated with bookings, it is the SRs’ responsibilities to
                                   ensure that the payments and fees associated with bookings have been paid and received. Whenever the
                                    payments and fees associated with bookings are processed on the Services the relevant terms stated
                                     herein will apply. </p>
                            <p>We try to implement certain measures to ensure that transactions are processed smoothly and the purchased
                                services are delivered by SPs successfully. In this regards, payout of each transaction may be
                                transferred to SPs after the purchased services are fully, or in some cases partly, delivered to SRs.
                                Funds earned in each month will be paid out to SPs in the following month. The processing time for SPs
                                to receive payouts in their provided bank account may vary and can take up to a few days. SPs are solely
                                responsible to provide correct bank account information. Every month, we use the exact bank account
                                information that is provided by SPs through their accounts under Account/Earnings/Bank Account section.
                                We do not repay an already paid out fund that has not been received by SPs due to their failure to
                                provide us with their correct bank account information. SPs can always update their bank account
                                information for the next payout in the following month.</p>
                            <p>The SPs are alone responsible for identifying, understanding, and complying with all laws, rules and
                                regulations that apply to their activities on the Zestlog Services. It is the SPs’ responsibility to
                                obtain any licenses, permits, or registrations required by applicable laws and regulations for their
                                activities on our Services to be permitted, legal and lawful. As a Member on the Zestlog Services, you
                                are not allowed to use the Services as a SP if you have not obtained required licenses, permits, or
                                registrations to be a legally permitted SP. </p>
                            <p>Members who wish to enter into a transaction with a SP on the Zestlog Services are alone responsible for
                                their choice of SP. We try to provide Members with information such as types of specialization,
                                education, and certifications that SPs have obtained, however, it is the Members responsibilities for
                                taking such information into consideration before they enter into a transaction with a SP.<br>You
                                understand and agree that Zestlog does not own, create, sell, resell, control, offer, deliver, or supply
                                any Listings. SPs alone are responsible for their Listings and for the services they provide. Upon the
                                confirmation of a booking request, Members enter into a contract directly with each other. Zestlog is
                                not and does not become a party to or any other participant in any contractual relationship between
                                Members. Zestlog is not acting as an agent in any capacity for any Member, except as specified herein.
                            </p>
                            <p>If you are a SP, when you accept or confirm a booking request submitted by a SR, you are entering into a
                                legally binding agreement with the SR and are required to provide your service(s) to the SR as described
                                in the booking description. If you are a SR, upon booking confirmation, a legally binding agreement is
                                formed between you and your SP, subject to any additional rules, terms and conditions specified in the
                                booking description at the time the booking is submitted. If you complete a booking request on behalf of
                                one or more additional Members, you represent and warrant that you are legally authorized to act on
                                behalf of them and they acknowledge and agrees to these Terms.</p>
                            <p>While we may help facilitate the resolution of disputes, Zestlog has no control over and does not
                                guarantee (i) the quality, safety, suitability, or legality of any Listings or services, (ii) the truth
                                or accuracy of any Listing descriptions, Ratings, Reviews, or other Members’ Contents, or (iii) the
                                performance, knowledge, trustworthiness, ethics, or honesty of any Member. Zestlog does not endorse any
                                Member or Listing. Any references to a Member being "Verified" (or similar terms) only indicate that the
                                Member has completed a relevant verification or identification process and nothing else. Any such
                                description is not an endorsement, certification or guarantee by Zestlog about any Member, including of
                                the Member\'s identity or educational background or whether the Member is trustworthy, safe or suitable.
                                The placement and ranking of SPs or Listings in search results on the Zestlog Services may vary and
                                depend on a variety of factors, such as Members search preferences, price and calendar availability,
                                ratings and reviews, and activity level. As a SP, you agree that it is your responsibility for deciding
                                and at your own risk to decide whether to make or accept a booking or an order, or communicate,
                                interact, or enter into a contract with other Members, whether online or in person.</p>
                            <p>If you choose to be a SP and publish your Listings on the Zestlog Services, your relationship with
                                Zestlog is limited to being an independent, third-party contractor, and not an employee, agent, or joint
                                venturer of Zestlog for any reason, and you act exclusively on your own behalf and for your own benefit,
                                and not on behalf, or for the benefit, of Zestlog. You acknowledge and agree that Zestlog does not
                                control you generally or under these Terms specifically, and you have complete discretion whether (i) to
                                create or close your account (ii) to create, publish or delete your Listings and (iii) to accept or
                                reject bookings.</p>
                            <p>If you choose to be a SP and publish your Listings on the Zestlog Services, you acknowledge and agree
                                that you are solely responsible for identifying and fulfilling your legal obligations and to report or
                                include in your Listing Fees any applicable VAT or other direct or indirect taxes applicable to your
                                activities and benefits on the Zestlog Services ("Taxes"). By default, the booking subtotal of all
                                Listings set by SPs includes all applicable Taxes. Zestlog is not responsible for managing or handling
                                SPs’ legal obligations to governmental authorities including tax authorities. Zestlog manages VAT
                                related obligations applicable only on its own Service Fees.</p>
                            <p>In cases where the currency of a price of a service set by a SP is not the same as the currency chosen by
                                a SR, we will need to convert the currencies, and as a result, we will need to apply a currency exchange
                                rate. We try to ensure we apply the most updated currency exchange rates from trusted sources, however,
                                we cannot guarantee that those exchange rates match with your preferred exchange rates. Zestlog and the
                                third party that provides us with the exchange rates do not accept any liability for any mismatch
                                between the exchange rates that is applied during price calculations and your preferred exchange
                                rates.</p>
                            <p>In cases where the price of a service on our Services contains a fraction of a unit of a currency (e.g.
                                £428.36 or $751.84), we round the price either up or down to produce a whole number. As a rule, when a
                                price contains a fraction of a unit of a currency, we round the price to the nearest whole unit (e.g.
                                £428.36 is rounded to £428, and £751.84 is rounded to £752), and if the distance from the two whole
                                units is equal, we round the price to the higher of the whole unit (e.g. £246.50 is rounded to
                                £247).</p>
                            <p>In cases of disputes between Members, upon Zestlog’s request Members are required to participate in
                                mediation or a similar resolution process. Failure to participate in such process may result in negative
                                consequences. The resolution process may be conducted by Zestlog or a third party selected by Zestlog.
                                In the case a third party is selected to conduct a resolution, the third party fee is divided
                                half-and-half between SP and SR. Upon the completion of the resolution process, Members are required to
                                accept the decision made by Zestlog or the third party selected by Zestlog. </p>
                            <h1>
                                <li>How We Fund Our Services</li>
                            </h1>
                            <p>To help operate the Zestlog Services and continue improving the Services, we must fund our Services. We
                                grant you a limited, non-exclusive, non-sublicensable, revocable, nontransferable license to access and
                                use our Services under the Terms herein, and in return, you agree and accept that we retain right to
                                employ a method or a number of methods of generating funds (such as service fees, subscription fees and
                                advertising fees) on or through our Services.<br><br>In the case of service fees, when a transaction is
                                made on or through the Services, in consideration for the use of our Services, we may charge fees to the
                                SP (the “SP Fees”) and the SR (the “SR Fees”) (collectively, “Service Fees”).</p>
                            <p>The SP Fee is typically equal or below 5% of <i>the transaction subtotal</i> for most Listings, unless
                                otherwise specified on the Services, and <i>is automatically deducted from the SPs’ payouts. The
                                    transaction subtotal includes the Listing fee and any other additional fees, if applicable, but
                                    excluding Service Fees and the VAT applicable to Service Fees.</i></p>
                            <p>The SR Fee is typically 12% of <i>the transaction subtotal</i> for most Listings, unless otherwise
                                specified on the Services, and collected when a transaction is made. The Total Fees will be presented to
                                the SR prior to completing a transaction. A fixed minimum Service Fee may be applied if the transaction
                                subtotal is lower than a certain minimum amount.<br><br>Except as otherwise provided on the Services,
                                Service Fees are non-refundable. All prices and fees that we charge are conditional and can be adjusted
                                at any time without a prior notice. Such changes in prices and fees will not affect any bookings or
                                transactions made prior to the effective date of the changes. </p>
                            <h1>
                                <li>Additional Provisions</li>
                            </h1>
                            <p>By accepting these Terms you understand and agree that all rights, titles, and interests in and to the
                                Services (excluding Content made available by Members) are and will remain the exclusive property of
                                Zestlog. With the exception of users-generated content, everything that is displayed, made available on,
                                or can be obtained from or through the Services is a property of Zestlog, and may be protected by
                                relevant laws such as trademark rights, copyrights, database rights, design rights or patents. It is
                                explicitly prohibited to copy, reproduce, modify, transfer, transmit, publish or use the Zestlog
                                properties unless explicitly permitted by Zestlog in written form. <br><br> <i>In connection to your
                                    access to or use of our Services, you agree that if you have any claim, cause of action, or dispute
                                    against us,</i> the laws of the state or the country that we choose will govern this Contract and
                                your claim, cause of action, or dispute. You agree that it is up to us to choose which court shall have
                                jurisdiction. You also agree that if any provision of this Contract is held to be unenforceable or
                                invalid, the remaining provisions of the Contract will remain in full effect.</p>
                            <p>You agree and accept that your Listings and certain Content on and through the Services may be displayed
                                on other websites, in applications, within emails, and in online and offline advertisements.<br><br> You
                                agree that, to assist Members who speak different languages, Listings and certain Contents on or through
                                the Services may be translated, in whole or in part, into other languages. Zestlog does not guarantee
                                the accuracy or quality of such translations and Members are responsible for reviewing and verifying the
                                accuracy of such translations.<br><br> The Services may contain links to third-party websites or
                                resources (“Third-Party Services”). Such Third-Party Services may be subject to different terms and
                                conditions and privacy practices. You agree that Zestlog is not responsible or liable for the
                                availability or accuracy of such Third-Party Services, or the content, products, or services available
                                from such Third-Party Services. Links to such Third-Party Services are not Zestlog endorsements of such
                                Third-Party Services.</p>
                            <p>We are not responsible for the confirmation of any Member’s identity. However, for transparency, safety,
                                and fraud prevention purposes, and as permitted by applicable laws, we may, but have no obligation (i)
                                to ask Members to provide a form of government-issued identification or undertake additional checks
                                designed to help verify the identities or backgrounds of Members, (ii) to screen Members against third
                                party databases or other sources and (iii) to obtain reports from public records of criminal convictions
                                or sex offender registrations or an equivalent version of background or registered sex offender checks
                                in your local jurisdiction (if available). Identity verification is a feature we use to verify that you
                                are the person you say you are. If your identity is verified by us, an “Identity Verified” icon may
                                appear publicly on your profile. To receive the Identity Verified icon, you can choose to send us
                                required documents and request us to verify your identity. We emphasize that as long as we have not
                                requested you to provide a government-issued ID, the identity verification is totally optional and you
                                can choose to skip it. However, in some case, the ID verification may be a prerequisite. For example,
                                one of features we use is to verify SPs’ formal education where SPs receive a public mark (an icon or a
                                tick) on their profile. To verify a SP’s formal education, the SP’s ID is required for the purpose of
                                fraud prevention.</p>
                            <p>Some areas of our Services may use Third-Party services. Your access to or use of the Third-Party
                                services on or through our Services may be subject to agreeing to the Third Party Terms of Services.<br><br>
                                If you feel that any Member that you interact with is acting or has acted inappropriately while using
                                the Zestlog Services, you should immediately report such person to the appropriate authorities and then
                                to Zestlog by contacting us via “report@zestlog.com” with information such as your police station and
                                report number (if available). You agree that any report you make will not obligate us to take any action
                                (beyond that required by law, if any).</p>
                            <h1>
                                <li>Terms of Termination</li>
                            </h1>
                            <p>If you wish to terminate this Contract, you can do so at any time by permanently closing (also known as
                                deleting) your account and discontinuing your access to or use of our Services. You may close your
                                account at any time by sending us an account termination request via email to the email address
                                “accounttermination@zestlog.com”. In the case when you have send us an account termination request via
                                email and have not received any response or delivery confirmation from us, you can write to us at the
                                following postal address: Zestlog LTD, 27 Old Gloucester Street, London, United Kingdom.<br><br> You
                                agree that if you are a SP and choose to close your account permanently, any confirmed booking(s) will
                                be automatically cancelled and your client(s) (described herein as SRs) will receive a full refund
                                (excluding the Service Fee). If you close your account as a SR, any confirmed booking(s) will be
                                automatically cancelled and no refund will be made to you. <br><br> Zestlog reserves right to, at its
                                own discretion or required by law, terminate this Contract, or suspend or prohibit your access to or use
                                of the Services, whether permanently or temporarily, at any time, without prior notice if (i) you have
                                breached your obligations under these Terms, our Policies or Guidelines, (ii) you have violated
                                applicable laws, regulations or third party rights, or (iii) Zestlog believes that such action is
                                appropriate (for example in the case of inappropriate, offensive, or violent behavior of a Member) to
                                protect the property of Zestlog, its Members, or Third Parties.</p>
                            <p>If you are a SP and we terminate this Contract with you or prohibit your access to or use of our
                                Services, irrespective of preexisting cancellation policies, (i) you will not be entitled to any further
                                payout or compensation, and (ii) the existing funds in your account will be used to refund the bookings
                                that you have already confirmed. If you are a SR and we terminate this Contract with you or prohibit
                                your access to or use of our Services, irrespective of preexisting cancellation policies, you will not
                                be entitled to any refund for any of your bookings that have been confirmed by a SP. If we terminate
                                this Contract with you or prohibit your access to or use of our Services, whether you are a SP or a SR,
                                the pending bookings (bookings not yet confirmed) will be cancelled immediately and the payments of such
                                bookings will not be processed.</p>
                            <h1>
                                <li>Disclaimers</li>
                            </h1>
                            <p>You acknowledge and agree that your access to or use of the Services are absolutely voluntarily and at
                                your own risk. You agree that your use of the Services may carry inherent risk, and by using any of the
                                Services, you choose to accept those risks voluntarily. <br><br> You accept that the Services and the
                                Content are provided to you by Zestlog on a basis of “as is” and “as available”, without warranty of any
                                kind, either expressed or implied, including any potential or existing defect or error. You agree that
                                it has been your responsibility to investigate the Zestlog Services, and any law, rule, or regulation
                                that may be applicable to your use of the Services. You acknowledge and agree that you are not relying
                                upon any statement made by Zestlog and have done all necessary investigations related to your use of the
                                Services.<br><br> To the maximum extent permitted by law, Zestlog makes no warranty or representation of
                                any kind and disclaims all responsibilities and liabilities for: (i) the accuracy, suitability,
                                completeness, availability, merchantability, non-infringement, security or reliability of the Services
                                or the Content; (ii) any harm to your electrical device or computer system, loss of your data whether
                                private or public data, or any other harms that may result from your access to or use of the Services or
                                the Content; (iii) the failure to store or transmit, or the deletion of any Content and other
                                communications maintained by the Services; (iv) any interruption or discontinuity in the availability,
                                security, or operation of the Service; or (v) any harm, injury, or death that arise in any way from the
                                use of the Services. You accept full responsibility for the choices you make before, during and after
                                your access to and use of the Services.</p>
                            <h1>
                                <li>Limitations of Liability</li>
                            </h1>
                            <p>TO THE MAXIMUM EXTENT PERMITTED BY LAW, ZESTLOG SHALL NOT BE LIABLE TO YOU, OR ANY MEMBER GENERALLY, FOR
                                ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL OR PUNITIVE DAMAGES, OR ANY LOSS OF PROFITS OR
                                REVENUES, WHETHER INCURRED DIRECTLY OR INDIRECTLY, OR ANY LOSS OF DATA, OPPORTUNITIES, REPUTATION, USE,
                                GOODWILL, OR OTHER INTANGIBLE LOSSES, RESULTING FROM (I) YOUR ACCESS TO OR USE OF OR INABILITY TO ACCESS
                                OR USE THE SERVICES; (II) ANY CONDUCT OR CONTENT OF ANY MEMBER OR THIRD PARTY ON THE SERVICES, INCLUDING
                                WITHOUT LIMITATION, ANY DEFAMATORY, OFFENSIVE OR ILLEGAL CONDUCT OF OTHER MEMBERS OR THIRD PARTIES;
                                (III) ANY CONTENT OBTAINED FROM OR AVAILABLE ON OR THROUGH THE SERVICES; OR (IV) UNAUTHORIZED ACCESS,
                                USE OR ALTERATION OF YOUR TRANSMISSIONS OR CONTENT. <br><br> IN NO EVENT SHALL THE AGGREGATE LIABILITY
                                OF ZESTLOG EXCEED THE GREATER OF ONE HUNDRED U.S. DOLLARS (100.00 USD) OR THE AMOUNT YOU PAID ZESTLOG,
                                IF ANY, IN THE PAST SIX MONTHS FOR THE SERVICES GIVING RISE TO THE CLAIM. <br><br> THIS LIMITATION OF
                                LIABILITY SHALL APPLY TO ALL CLAIMS OF LIABILITY, WHETHER BASED ON WARRANTY, CONTRACT, STATUTE, TORT
                                (INCLUDING NEGLIGENCE) OR OTHERWISE, AND WHETHER OR NOT ZESTLOG HAS BEEN INFORMED OF THE POSSIBILITY OF
                                ANY SUCH DAMAGE, AND EVEN IF REMEDIES SET FORTH HEREIN IS FOUND TO HAVE FAILED OF ITS ESSENTIAL PURPOSE.
                            </p>
                            <h1>
                                <li>Changes</li>
                            </h1>
                            <p>We reserve right to revise our Terms of Service and Privacy Policy at any time. If we revise our Terms of
                                Service and Privacy Policy, we will publish the revised version on our Services. The changes cannot be
                                retroactive, and the most current version of Terms of Service and Privacy Policy, which will always be
                                available at www.zestlog.com, will govern our relationship with you. If you object to any revisions, you
                                can send your objection to us by contacting via the email address “termsofservice@zestlog.com” and wait
                                for a response from us before you resume your use of our Services, or you may close your account and
                                stop accessing and using our Services entirely. We try to notify you of the revisions through our
                                Services, or by other means, so you will have the opportunity to review the changes, however, your
                                continued access to or use of our Services after we made the new revisions publicly available means that
                                you are consenting to the most updated Contract, Terms of Service and Privacy Policy.</p>
                            <h1>
                                <li>How to Contact Us</li>
                            </h1>
                        </ol>
                        <p>The email addresses below are designed for the following purposes.
                        <ul>
                            <li>For general inquiries, please contact “contact@zestlog.com”</li>
                            <li>For reporting content or accounts, please contact “report@zestlog.com”</li>
                            <li>For reporting an unauthorized access to your account, please contact “unauthorizedaccess@zestlog.com”.
                            </li>
                            <li>For closing account, please contact “accounttermination@zestlog.com”</li>
                            <li>For inquiries related to Terms of Service or Privacy Policy, please contact
                                “termsofservice@zestlog.com”.
                            </li>
                        </ul>
                        <br>
                        In the cases which you have not received any reply to the email(s) you have sent to us, you may need to write to
                        us at the following postal address: Zestlog LTD, 27 Old Gloucester Street, London, United Kingdom.
                        </p><br><br>';

        TermsAndPolicy::find(1);
    }
}
