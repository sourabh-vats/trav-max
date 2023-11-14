<style>
    .refer-and-earn-section {
        background-color: #fff;
        padding: 0 0 106px;
    }

    .rightDiv {
        float: left;
        width: 100%;
        text-align: center;
        /* margin-top: 50px; */
        background-color: #fff;
        padding: 20px;
        margin-bottom: 20px;
        min-height: 500px;
        padding-top: 0px;
    }

    .details-container {
        position: relative;
        width: 100%;
        height: 600px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        background-image: linear-gradient(298deg, #e5ba6e, #ed9092 50%, #cc80bd);
        padding-top: 36px;
        margin-bottom: 26px;
    }

    .white-gradient {
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg, hsla(0, 0%, 100%, 0), hsla(0, 0%, 100%, .8) 85%, #fff 95%, #fff);
    }

    .white-gradient header {
        margin: 0 148px;
        text-align: center;
    }

    .hero-img-container {
        /* overflow: hidden; */
        background-color: #fff;
        width: calc(100% - 188px);
        height: 295px;
        border-radius: 16px;
        margin: 16px auto 0;
    }

    .referral-code {
        display: grid;
        grid-template-columns: 76px auto 35px 35px;
        padding: 10px 34px;
        width: 400px;
        background-color: #f9fafc;
        border-radius: 8px;
        line-height: 1;
        margin: 0 auto 16px;
        transform: translateY(86px);
        align-items: center;
    }

    .hero-img-container img {
        height: auto;
        width: 100%;
    }

    .referral-code>span {
        font-size: 13px;
        color: #666;
        font-weight: 400;
        white-space: nowrap;
    }

    .referral-code h2 {
        font-size: 16px;
        font-weight: 600;
        color: #2a4057;
    }

    .referral-code>button {
        display: inline-flex;
        flex-flow: column;
        align-items: center;
        justify-content: center;
        border: 0;
        padding: 0;
        margin: 0;
        outline: none;
        border-radius: 50%;
        background-color: transparent;
    }

    .referral-sm-icons {
        width: 14px;
        height: 16px;
    }

    .referral-code>button>span {
        font-family: SourceSansPro;
        font-size: 10px;
        font-weight: 600;
        text-align: center;
        color: #999;
    }

    @media (max-width: 768px) {
        .details-container {
            height: auto;
        }

        .hero-img-container {
            width: 95%;
            border-radius: 0;
            height: auto;
        }

        .referral-code {
            width: 95%;
            box-sizing: border-box;
            padding: 10px;
            transform: translateY(0px);
        }

        .white-gradient header {
            margin: 0px 0px;
            text-align: center;
        }

        .referral-code h2 {
            font-size: 13px;
        }

        .rightDiv {
            padding: 0px;
        }

        .px-3 {
            padding-right: 0rem !important;
            padding-left: 0rem !important;
        }
    }
</style>
<div class="alert alert-success d-none" role="alert" id="copy_success">
    Link Copied Successfully!
</div>
<section class="refer-and-earn-section rightDiv">
    <main class="details-container">
        <div class="white-gradient">
            <header>
                <h1>Invite Friends &amp; Earn</h1>
                <h3 class="refer-meta-data">Invite Friends &amp; Earn Points For Every Friend</h3>
            </header>
            <div class="hero-img-container"><img src="/images/Referral-image-Desktop.webp" loading="eager"></div>
            <!-- <div class="referral-code"><span class="">Referral Code:</span>
            <?php echo $cust_id; ?>
            </div> -->
            <div class="referral-code"><span class="">Referral Code:</span>
                <input id="the_text" type="hidden" value="<?php echo base_url() ?>signup?refer_id=<?php echo $cust_id; ?>" size="50">
                <h2><?php echo $cust_id; ?></h2><button type="button" onclick="copyById('the_text')"><img class="referral-sm-icons" src="/images/copy.png" alt="Copy icon"><span>copy</span></button><button type="button"><img class="referral-sm-icons" src="/images/share.png" alt="Share icon"><span>share</span></button>
            </div>
        </div>
    </main>
</section>
<script>
    copyById = function(id) {
        let text = document.getElementById(id)
        copyText(text.value)
    }
    copyText = function(textToCopy) {
        this.copied = false

        // Create textarea element
        const textarea = document.createElement('textarea')

        // Set the value of the text
        textarea.value = textToCopy

        // Make sure we cant change the text of the textarea
        textarea.setAttribute('readonly', '');

        // Hide the textarea off the screnn
        textarea.style.position = 'absolute';
        textarea.style.left = '-9999px';

        // Add the textarea to the page
        document.body.appendChild(textarea);

        // Copy the textarea
        textarea.select()

        try {
            var successful = document.execCommand('copy');
            this.copied = true
        } catch (err) {
            this.copied = false
        }

        textarea.remove()
        $("#copy_success").removeClass("d-none");

    }
</script>