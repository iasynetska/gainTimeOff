//Adaptive reCAPTCHA
function changeCaptchaSize() 
{
    var reCaptchaWidth = 302;
    var containerWidth = $(".register_parent").width();
    if(reCaptchaWidth !== containerWidth) 
    {
        var reCaptchaScale = containerWidth / reCaptchaWidth;
        $(".g-recaptcha").css(
        {
            "transform":"scale("+reCaptchaScale+")",
            "transform-origin":"0 0"
        });
    }
}

$(window).ready(function()
    {
        changeCaptchaSize();
    }
);

$(window).resize(function()
    {
        changeCaptchaSize();
    }
);

