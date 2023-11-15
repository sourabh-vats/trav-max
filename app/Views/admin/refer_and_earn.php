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

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 1030;
    }

    .popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 20px 30px;
        z-index: 1000;
        width: 90%;
        max-width: 400px;
        text-align: left;
    }

    .popup-body>a {
        color: #000;
        margin-bottom: 20px;
        display: flex;

    }

    .close-popup {
        font-size: 25px;
        cursor: pointer;
    }

    .popup-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .popup-body {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .icon {
        border: 1px solid gray;
        border-radius: 25px;
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;

    }

    .icon>img {
        height: 15px;
        width: 15px;

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
            <div class="overlay" id="overlay">
                <div class="popup" id="popup">
                    <div class="popup-header">

                        <h3>Share Via</h3>
                        <span class="close-popup" id="close-popup">&times;</span>
                    </div>
                    <div class="popup-body">
                        <a href="#" onclick="shareOnWhatsApp()">
                            <div style="display: flex; align-items:center">
                                <div class="icon"><img src="/images/whatsapp.png" /></div>
                                <div style="margin-left: 10px; ">WhatsApp</div>
                            </div>
                        </a>
                        <a href="#" onclick="shareOnInstagram()">
                            <div style="display: flex; align-items:center">
                                <div class="icon"><img src="/images/instagram.png" /></div>
                                <div style="margin-left: 10px;">Instagram </div>
                            </div>
                        </a>
                        <a href="#" onclick="shareOnFacebook()">
                            <div style="display: flex; align-items:center">
                                <div class="icon"><img src="/images/facebook.png" /></div>
                                <div style="margin-left: 10px;">Facebook </div>
                            </div>
                        </a>
                        <a href="#" onclick="shareOnTwitter()">
                            <div style="display: flex; align-items:center">
                                <div class="icon"><img src="/images/twitter.png" /></div>
                                <div style="margin-left: 10px;">Twitter </div>
                            </div>
                        </a>
                        <a href="#" onclick="copyLink()" style="padding-bottom: 0px;">
                            <div style="display: flex; align-items:center">
                                <div class="icon"><img src="/images/chain.png" /></div>
                                <div style="margin-left: 10px;"> Copy Link</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="referral-code"><span class="">Referral Code:</span>
                <input id="the_text" type="hidden" value="<?php echo base_url() ?>signup?refer_id=<?php echo $cust_id; ?>" size="50">
                <h2><?php echo $cust_id; ?></h2><button type="button" onclick="copyById('the_text')"><img class="referral-sm-icons" src="/images/copy.png" alt="Copy icon"><span>copy</span></button><button type="button" class="share-button"><img class="referral-sm-icons" src="/images/share.png" alt="Share icon"><span>share</span></button>
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
    $(document).ready(function() {
        $(".share-button").click(function() {
            $("#overlay").fadeIn();
        });

        $("#close-popup").click(function() {
            $("#overlay").fadeOut();
        });
    });

    function shareOnWhatsApp() {
        var shareURL = '<?php echo base_url() ?>signup?refer_id=<?php echo $profile[0]['customer_id']; ?>';
        var imageURL = 'http://localhost:8080/images/addidas.png';

        var whatsappURL = 'https://api.whatsapp.com/send?' +
            'text=' + encodeURIComponent(shareURL) +
            '&media=' + encodeURIComponent(imageURL);

        window.open(whatsappURL, '_blank');
    }

    function shareOnInstagram() {
        var shareURL = '<?php echo base_url() ?>signup?refer_id=<?php echo $profile[0]['customer_id']; ?>';
        var instagramURL = 'https://www.instagram.com/create/story/' +
            '?url=' + encodeURIComponent(shareURL);
        window.open(instagramURL, '_blank');
    }

    function copyLink() {
        var shareURL = '<?php echo base_url() ?>signup?refer_id=<?php echo $profile[0]['customer_id']; ?>';
        var input = document.createElement('input');
        input.value = shareURL;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        alert('Link copied to clipboard');
    }
</script>