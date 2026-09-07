<?= view('frontend/inc/header') ?>
<style>
    
        /* =========================================
           HERO
        ========================================= */

        .terms-hero {
            min-height: 430px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, .08);

            background:
                radial-gradient(circle at 10% 50%,
                    rgba(0, 240, 255, .10),
                    transparent 32%),
                radial-gradient(circle at 90% 40%,
                    rgba(160, 0, 255, .10),
                    transparent 35%);
        }

        .terms-hero::before {
            content: "";
            position: absolute;
            width: 700px;
            height: 700px;
            right: -250px;
            top: -300px;

            border: 1px solid rgba(0, 240, 255, .08);
            border-radius: 50%;

            box-shadow:
                0 0 80px rgba(0, 240, 255, .04),
                inset 0 0 80px rgba(160, 0, 255, .03);
        }

        .terms-hero::after {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;
            left: -300px;
            bottom: -350px;

            border: 1px solid rgba(255, 0, 200, .08);
            border-radius: 50%;
        }

        .hero-inner {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 850px;
            margin: auto;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--cyan);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .section-label::before {
            content: "";
            width: 7px;
            height: 7px;
            background: var(--cyan);
            border-radius: 50%;
            box-shadow: 0 0 12px var(--cyan);
        }

        .hero-inner h1 {
            font-size: clamp(42px, 6vw, 76px);
            line-height: 1;
            font-weight: 800;
            margin-bottom: 25px;
        }

        .hero-inner h1 span {
            background: linear-gradient(90deg,
                    var(--cyan),
                    #7181ff,
                    var(--pink));

            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-inner p {
            max-width: 700px;
            margin: auto;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.9;
        }

        .updated {
            margin-top: 20px;
            color: #6f7780;
            font-size: 10px;
            letter-spacing: .5px;
        }


        /* =========================================
           TERMS CONTENT
        ========================================= */

        .terms-section {
            padding: 90px 0;
            position: relative;
        }

        .terms-layout {
            display: grid;
            grid-template-columns: 270px 1fr;
            gap: 60px;
            align-items: start;
        }


        /* SIDEBAR */

        .terms-sidebar {
            position: sticky;
            top: 105px;
            border: 1px solid rgba(0, 240, 255, .15);
            background: rgba(11, 14, 17, .75);
            border-radius: 16px;
            padding: 25px;
        }

        .terms-sidebar-title {
            color: white;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .terms-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .terms-nav li {
            margin-bottom: 4px;
        }

        .terms-nav a {
            display: block;
            padding: 9px 10px;
            border-radius: 7px;
            color: #818891;
            font-size: 10px;
            line-height: 1.5;
            transition: .25s;
        }

        .terms-nav a:hover {
            color: var(--cyan);
            background: rgba(0, 240, 255, .05);
        }


        /* CONTENT */

        .terms-content {
            max-width: 820px;
        }

        .intro-card {
            padding: 28px 30px;
            margin-bottom: 45px;

            border: 1px solid rgba(0, 240, 255, .25);
            border-radius: 15px;

            background:
                linear-gradient(135deg,
                    rgba(0, 240, 255, .055),
                    rgba(160, 0, 255, .025));

            box-shadow:
                0 0 35px rgba(0, 240, 255, .035);
        }

        .intro-card p {
            color: #b4bac1;
            font-size: 13px;
            line-height: 1.9;
            margin: 0;
        }

        .terms-block {
            padding-bottom: 38px;
            margin-bottom: 38px;
            border-bottom: 1px solid rgba(255, 255, 255, .07);
        }

        .terms-block:last-child {
            border-bottom: 0;
        }

        .terms-number {
            color: var(--cyan);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .terms-block h2 {
            font-size: 23px;
            line-height: 1.3;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .terms-block h2 span {
            background: linear-gradient(90deg,
                    var(--cyan),
                    #9b72ff);

            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .terms-block p {
            color: #9299a2;
            font-size: 12px;
            line-height: 1.9;
            margin-bottom: 13px;
        }

        .terms-block ul {
            margin: 15px 0 0;
            padding-left: 20px;
        }

        .terms-block li {
            color: #9299a2;
            font-size: 12px;
            line-height: 1.9;
            margin-bottom: 8px;
            padding-left: 5px;
        }

        .terms-block li::marker {
            color: var(--cyan);
        }

        .highlight {
            color: #dce1e6;
        }


        /* =========================================
           CTA
        ========================================= */

        .cta-section {
            padding: 20px 0 90px;
        }

        .cta-box {
            min-height: 200px;
            border: 1px solid var(--cyan);
            border-radius: 18px;
            padding: 40px 50px;

            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 30px;

            position: relative;
            overflow: hidden;

            background:
                radial-gradient(circle at 15% 50%,
                    rgba(0, 240, 255, .14),
                    transparent 30%),
                radial-gradient(circle at 90% 50%,
                    rgba(255, 0, 200, .12),
                    transparent 30%);
        }

        .cta-icon {
            font-size: 45px;
            color: var(--cyan);
            text-shadow: 0 0 25px var(--cyan);
        }

        .cta-box h2 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .cta-box h2 span {
            color: var(--cyan);
        }

        .cta-box p {
            color: #999fa8;
            font-size: 11px;
            line-height: 1.7;
            margin: 0;
        }

        .btn-neon {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 14px 25px;
            border-radius: 30px;
            border: 1px solid var(--cyan);
            background: var(--cyan);
            color: #000;
            font-size: 12px;
            font-weight: 700;
            transition: .3s;
            white-space: nowrap;
        }

        .btn-neon:hover {
            background: transparent;
            color: var(--cyan);
            box-shadow: 0 0 30px rgba(0, 240, 255, .25);
        }

    </style>
    <!-- main-area -->
    <main class="main-area fix">

 


    <!-- =========================================
     HERO
========================================= -->

    <section class="terms-hero breadcrumb__area breadcrumb__bg">

        <div class="container-custom">

            <div class="hero-inner">

                <div class="section-label">
                    Legal Information
                </div>

                <h1>
                    Terms &
                    <span>Conditions</span>
                </h1>

                <p>
                    Please read these terms carefully before using Neon Stories,
                    placing an enquiry, requesting a quotation or purchasing our
                    products and services.
                </p>

                <div class="updated">
                    <i class="fa-regular fa-clock"></i>
                    Last Updated: September 2026
                </div>

            </div>

        </div>

    </section>



    <!-- =========================================
     TERMS CONTENT
========================================= -->

    <section class="terms-section">

        <div class="container-custom">

            <div class="terms-layout">


                <!-- SIDEBAR -->

                <aside class="terms-sidebar">

                    <div class="terms-sidebar-title">
                        On This Page
                    </div>

                    <ul class="terms-nav">

                        <li>
                            <a href="#acceptance">
                                01. Acceptance of Terms
                            </a>
                        </li>

                        <li>
                            <a href="#website-use">
                                02. Website Use
                            </a>
                        </li>

                        <li>
                            <a href="#products">
                                03. Products & Custom Orders
                            </a>
                        </li>

                        <li>
                            <a href="#quotes">
                                04. Enquiries & Quotations
                            </a>
                        </li>

                        <li>
                            <a href="#pricing">
                                05. Pricing & Payment
                            </a>
                        </li>

                        <li>
                            <a href="#orders">
                                06. Orders & Confirmation
                            </a>
                        </li>

                        <li>
                            <a href="#delivery">
                                07. Delivery & Installation
                            </a>
                        </li>

                        <li>
                            <a href="#returns">
                                08. Returns & Refunds
                            </a>
                        </li>

                        <li>
                            <a href="#intellectual">
                                09. Intellectual Property
                            </a>
                        </li>

                        <li>
                            <a href="#liability">
                                10. Limitation of Liability
                            </a>
                        </li>

                        <li>
                            <a href="#privacy">
                                11. Privacy
                            </a>
                        </li>

                        <li>
                            <a href="#changes">
                                12. Changes to Terms
                            </a>
                        </li>

                        <li>
                            <a href="#contact">
                                13. Contact Us
                            </a>
                        </li>

                    </ul>

                </aside>



                <!-- CONTENT -->

                <main class="terms-content">


                    <!-- INTRO -->

                    <div class="intro-card">

                        <p>
                            Welcome to <span class="highlight">Neon Stories</span>.
                            By accessing or using our website, placing an enquiry,
                            requesting a quotation, or purchasing our products,
                            you agree to be bound by these Terms & Conditions.
                            Please read them carefully before using our website
                            or services.
                        </p>

                    </div>



                    <!-- 01 -->

                    <div class="terms-block" id="acceptance">

                        <div class="terms-number">
                            01 — ACCEPTANCE OF TERMS
                        </div>

                        <h2>
                            Your Agreement With
                            <span>Neon Stories</span>
                        </h2>

                        <p>
                            By accessing this website or using any of our services,
                            you confirm that you have read, understood and agreed
                            to these Terms & Conditions.
                        </p>

                        <p>
                            If you do not agree with any part of these terms,
                            please do not use our website or services.
                        </p>

                    </div>



                    <!-- 02 -->

                    <div class="terms-block" id="website-use">

                        <div class="terms-number">
                            02 — WEBSITE USE
                        </div>

                        <h2>
                            Responsible Use of Our
                            <span>Website</span>
                        </h2>

                        <p>
                            You agree to use the Neon Stories website only for
                            lawful purposes and in a way that does not interfere
                            with the operation, security or availability of the
                            website.
                        </p>

                        <ul>
                            <li>Do not attempt to gain unauthorized access to the website.</li>
                            <li>Do not use the website for fraudulent or unlawful activities.</li>
                            <li>Do not reproduce or misuse website content without permission.</li>
                            <li>Do not introduce malicious software or harmful code.</li>
                        </ul>

                    </div>



                    <!-- 03 -->

                    <div class="terms-block" id="products">

                        <div class="terms-number">
                            03 — PRODUCTS & CUSTOM ORDERS
                        </div>

                        <h2>
                            Custom Products &
                            <span>Design Approval</span>
                        </h2>

                        <p>
                            Many Neon Stories products may be made according to
                            customer specifications, including custom wording,
                            colours, dimensions, designs and configurations.
                        </p>

                        <p>
                            Customers are responsible for reviewing and approving
                            artwork, spelling, dimensions and other specifications
                            before production begins.
                        </p>

                        <p>
                            Because custom-made products are created specifically
                            for individual customers, they may not be eligible
                            for cancellation, return or exchange once production
                            has started, except where required by applicable law
                            or expressly agreed by Neon Stories.
                        </p>

                    </div>



                    <!-- 04 -->

                    <div class="terms-block" id="quotes">

                        <div class="terms-number">
                            04 — ENQUIRIES & QUOTATIONS
                        </div>

                        <h2>
                            Enquiries, Designs &
                            <span>Quotations</span>
                        </h2>

                        <p>
                            Any quotation provided by Neon Stories is based on the
                            information available at the time of preparation.
                        </p>

                        <p>
                            Pricing may vary depending on final dimensions,
                            materials, design complexity, installation requirements,
                            delivery location and other project specifications.
                        </p>

                        <p>
                            A quotation does not constitute a confirmed order unless
                            it has been formally accepted and any required payment
                            or deposit has been received.
                        </p>

                    </div>



                    <!-- 05 -->

                    <div class="terms-block" id="pricing">

                        <div class="terms-number">
                            05 — PRICING & PAYMENT
                        </div>

                        <h2>
                            Pricing &
                            <span>Payment Terms</span>
                        </h2>

                        <p>
                            Product and service prices displayed on the website may
                            be changed from time to time without prior notice.
                        </p>

                        <p>
                            Where a custom quotation is provided, the applicable
                            price will be the price confirmed in the quotation or
                            order confirmation.
                        </p>

                        <ul>
                            <li>Payments must be made using the payment methods offered by Neon Stories.</li>
                            <li>Any applicable taxes, delivery or installation charges may be added to the order.</li>
                            <li>Production may begin only after the required payment or deposit is received.</li>
                            <li>Additional work or modifications requested after approval may result in additional
                                charges.</li>
                        </ul>

                    </div>



                    <!-- 06 -->

                    <div class="terms-block" id="orders">

                        <div class="terms-number">
                            06 — ORDERS & CONFIRMATION
                        </div>

                        <h2>
                            Order Processing &
                            <span>Confirmation</span>
                        </h2>

                        <p>
                            An order is considered confirmed once Neon Stories has
                            accepted the order and received any required payment.
                        </p>

                        <p>
                            Customers should carefully verify all order information,
                            including design, spelling, dimensions, colour,
                            quantity and delivery details before approving an order.
                        </p>

                    </div>



                    <!-- 07 -->

                    <div class="terms-block" id="delivery">

                        <div class="terms-number">
                            07 — DELIVERY & INSTALLATION
                        </div>

                        <h2>
                            Delivery &
                            <span>Installation</span>
                        </h2>

                        <p>
                            Delivery timelines provided by Neon Stories are
                            estimates unless a specific guaranteed delivery date
                            has been agreed in writing.
                        </p>

                        <p>
                            Delays may occur due to manufacturing requirements,
                            courier delays, weather, availability of materials,
                            installation conditions or circumstances beyond our
                            reasonable control.
                        </p>

                        <p>
                            Where installation is included, the customer must ensure
                            that the installation location is accessible, safe and
                            suitable for the agreed installation.
                        </p>

                    </div>



                    <!-- 08 -->

                    <div class="terms-block" id="returns">

                        <div class="terms-number">
                            08 — RETURNS & REFUNDS
                        </div>

                        <h2>
                            Returns,
                            <span>Refunds & Cancellations</span>
                        </h2>

                        <p>
                            Return, refund and cancellation eligibility depends on
                            the nature of the product or service and whether
                            production has already commenced.
                        </p>

                        <p>
                            Custom-made products may generally not be returnable
                            solely because the customer changes their mind after
                            production has started.
                        </p>

                        <p>
                            If a product arrives damaged or has a manufacturing
                            defect, customers should contact Neon Stories promptly
                            with relevant details and supporting photographs where
                            appropriate.
                        </p>

                    </div>



                    <!-- 09 -->

                    <div class="terms-block" id="intellectual">

                        <div class="terms-number">
                            09 — INTELLECTUAL PROPERTY
                        </div>

                        <h2>
                            Our Content &
                            <span>Creative Work</span>
                        </h2>

                        <p>
                            All website content, including logos, branding,
                            graphics, photographs, text, designs and other
                            materials, belongs to Neon Stories or its respective
                            licensors unless otherwise stated.
                        </p>

                        <p>
                            You may not copy, reproduce, modify, distribute or use
                            our intellectual property for commercial purposes
                            without prior written permission.
                        </p>

                    </div>



                    <!-- 10 -->

                    <div class="terms-block" id="liability">

                        <div class="terms-number">
                            10 — LIMITATION OF LIABILITY
                        </div>

                        <h2>
                            Service Limitations &
                            <span>Liability</span>
                        </h2>

                        <p>
                            Neon Stories will make reasonable efforts to provide
                            accurate information and reliable services.
                        </p>

                        <p>
                            To the extent permitted by applicable law, Neon Stories
                            shall not be responsible for indirect, incidental,
                            special or consequential losses arising from the use
                            of our website, products or services.
                        </p>

                    </div>



                    <!-- 11 -->

                    <div class="terms-block" id="privacy">

                        <div class="terms-number">
                            11 — PRIVACY
                        </div>

                        <h2>
                            Your Information &
                            <span>Privacy</span>
                        </h2>

                        <p>
                            Information submitted through our website may be used
                            to process enquiries, quotations, orders, payments,
                            delivery and customer support.
                        </p>

                        <p>
                            We take reasonable steps to protect customer information
                            and handle it in accordance with our applicable privacy
                            practices.
                        </p>

                    </div>



                    <!-- 12 -->

                    <div class="terms-block" id="changes">

                        <div class="terms-number">
                            12 — CHANGES TO THESE TERMS
                        </div>

                        <h2>
                            Updates to Our
                            <span>Terms</span>
                        </h2>

                        <p>
                            Neon Stories may update or modify these Terms &
                            Conditions from time to time.
                        </p>

                        <p>
                            Updated terms will be posted on this page with a revised
                            date. Your continued use of the website after changes
                            are posted constitutes acceptance of the updated terms,
                            subject to applicable law.
                        </p>

                    </div>



                    <!-- 13 -->

                    <div class="terms-block" id="contact">

                        <div class="terms-number">
                            13 — CONTACT US
                        </div>

                        <h2>
                            Questions About These
                            <span>Terms?</span>
                        </h2>

                        <p>
                            If you have any questions regarding these Terms &
                            Conditions, our products, quotations or services,
                            please contact the Neon Stories team.
                        </p>

                        <p>
                            We will be happy to assist you with any questions
                            relating to your order or our services.
                        </p>

                    </div>


                </main>

            </div>

        </div>

    </section>



    <!-- =========================================
     CTA
========================================= -->

    <section class="cta-section">

        <div class="container-custom">

            <div class="cta-box">

                <div class="cta-icon">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>

                <div>

                    <h2>
                        Need More
                        <span>Information?</span>
                    </h2>

                    <p>
                        If you have questions about our terms, products,
                        custom orders or services, our team is ready to help.
                    </p>

                </div>

                <a href="contact.html" class="btn-neon">
                    Contact Us
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>

        </div>

    </section>



    </main>

    <!-- Page Contact Us End -->
<?= view('frontend/inc/footerLink') ?>

    
</body>

</html>