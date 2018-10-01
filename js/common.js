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


//Confirmation box

function areYouSure(name)
{
    if (confirm("You really want to delete this profile?"))
    {
        deleteKid(name);
    };
};


//Delete Kid from database(dashboard_parent.php)
function deleteKid(name)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState === 4 && this.status === 200)
        {
            var divKid = document.getElementById("kid-"+name);
            divKid.parentNode.removeChild(divKid);
            alert(this.responseText);
        };
    };
    xhttp.open("GET", "services/do_delete_kid.php?name="+name, true);
    xhttp.send();
};


//Adding Subjects
function addSubject()
{
    var subject = document.getElementById("subject").value;
    
    var divMain = document.createElement('div');
    divMain.setAttribute("id", subject);
    var div = document.createElement('div');
    div.setAttribute("class", "subject_name");
    div.innerText = subject;
    
    
    var button = document.createElement('button');
    button.innerText = "-";
    button.setAttribute("onclick", "deleteSubject(\'"+subject+"\')");
    
    divMain.appendChild(div);
    divMain.appendChild(button);
    document.getElementById("section_subjects").appendChild(divMain);
}


//Delete Subject
function deleteSubject(subjectId)
{
    var subject = document.getElementById(subjectId);
    subject.parentNode.removeChild(subject);
}


//Save Subjects
function saveSubjects()
{
    var subjects = [];

    $(".subject_name").each(function()
    {
        subjects.push($(this).text());      
    });
    
//    console.log(subjects);
    var a = $(".subject_name").serialize();
    console.log(a);
}