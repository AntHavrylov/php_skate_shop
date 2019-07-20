

function showHideBoard()
{    $(document).ready(function(){
            if(document.getElementById("hidden").textContent=="0"){
                $("#gameboard").fadeOut();
                document.getElementById("hidden").innerHTML="1";
            }
            else
            {
                $("#gameboard").fadeIn();  
                document.getElementById("hidden").innerHTML="0";
            }
    });
}

function resetScore()
{   
    document.getElementById('oScore').innerHTML="<b>"+0+"</b>";
    document.getElementById('xScore').innerHTML="<b>"+0+"</b>";
    $(document).ready(function(){
        $("#reset").fadeOut();
    })
}


function newGame(){
    document.getElementById("status").innerHTML="game";
    document.getElementById("a1").src="empty.jpg";
    document.getElementById("a2").src="empty.jpg";
    document.getElementById("a3").src="empty.jpg";
    document.getElementById("b1").src="empty.jpg";
    document.getElementById("b2").src="empty.jpg";
    document.getElementById("b3").src="empty.jpg";
    document.getElementById("c1").src="empty.jpg";
    document.getElementById("c2").src="empty.jpg";
    document.getElementById("c3").src="empty.jpg";
    $(document).ready(function(){
        $("#new").fadeOut();
        $("#reset").fadeOut();
    });
    document.getElementById('head').innerHTML="The TicTacToe game";

}

function changePlayer(){
    if(document.getElementById('player').textContent == "O")
        {
            document.getElementById('player').innerHTML = "X";
        }
        else
        {
            document.getElementById('player').innerHTML = "O";
        }
}

function turn(id){

     if(document.getElementById('status').textContent=="game"){  
        if(document.getElementById(id).getAttribute("src")=="empty.jpg")
        {
            if(document.getElementById('player').textContent == "O")
            {
                document.getElementById(id).src="ring.jpg";
            }
            else
            {
                document.getElementById(id).src="cross.jpg";
            }
            checkWin();
            
        }
        else
        {
           // alert("this cell is'nt empty");
        }
    }
   

}

function checkWin(){
    if(
        //upper line
        (   (document.getElementById('a1').getAttribute("src")!="empty.jpg")
          &&(document.getElementById('a1').getAttribute("src")==document.getElementById('a2').getAttribute("src"))
          &&(document.getElementById('a1').getAttribute("src")==document.getElementById('a3').getAttribute("src"))
        )||
        //center line
        (
            (document.getElementById('b1').getAttribute("src")!="empty.jpg")
          &&(document.getElementById('b1').getAttribute("src")==document.getElementById('b2').getAttribute("src"))
          &&(document.getElementById('b1').getAttribute("src")==document.getElementById('b3').getAttribute("src"))
        )||
        //bottom line
        (
            (document.getElementById('c1').getAttribute("src")!="empty.jpg")
          &&(document.getElementById('c1').getAttribute("src")==document.getElementById('c2').getAttribute("src"))
          &&(document.getElementById('c1').getAttribute("src")==document.getElementById('c3').getAttribute("src"))
        )||
        //left diagonal
        (   (document.getElementById('a1').getAttribute("src")!="empty.jpg")
          &&(document.getElementById('a1').getAttribute("src")==document.getElementById('b2').getAttribute("src"))
          &&(document.getElementById('a1').getAttribute("src")==document.getElementById('c3').getAttribute("src"))
        )||
        //right diagonal
        (   (document.getElementById('a3').getAttribute("src")!="empty.jpg")
          &&(document.getElementById('a3').getAttribute("src")==document.getElementById('b2').getAttribute("src"))
          &&(document.getElementById('a3').getAttribute("src")==document.getElementById('c1').getAttribute("src"))
        )||
        //left line
        (   (document.getElementById('a1').getAttribute("src")!="empty.jpg")
          &&(document.getElementById('a1').getAttribute("src")==document.getElementById('b1').getAttribute("src"))
          &&(document.getElementById('a1').getAttribute("src")==document.getElementById('c1').getAttribute("src"))
        )||
        //center line
        (   (document.getElementById('a2').getAttribute("src")!="empty.jpg")
          &&(document.getElementById('a2').getAttribute("src")==document.getElementById('b2').getAttribute("src"))
          &&(document.getElementById('a2').getAttribute("src")==document.getElementById('c2').getAttribute("src"))
        )||
        //right line
        (   (document.getElementById('a3').getAttribute("src")!="empty.jpg")
          &&(document.getElementById('a3').getAttribute("src")==document.getElementById('b3').getAttribute("src"))
          &&(document.getElementById('a3').getAttribute("src")==document.getElementById('c3').getAttribute("src"))
        )
    )
    {
        document.getElementById('status').innerHTML = "win";
        document.getElementById('head').innerHTML="Player"+document.getElementById('player').textContent+" won!!!";
        if(document.getElementById('player').textContent=="O")
        {   
            var x = parseInt(document.getElementById('oScore').textContent)+1;
            document.getElementById('oScore').innerHTML="<b>"+x+"</b>";
        }
        else
        {
            var x = parseInt(document.getElementById('xScore').textContent)+1;
            document.getElementById('xScore').innerHTML="<b>"+x+"</b>";
        }
        $(document).ready(function(){
            $("#new").fadeIn();
            $("#reset").fadeIn();
        });
    }
    else if(
    (document.getElementById('a1').getAttribute("src")!="empty.jpg")&&
    (document.getElementById('a2').getAttribute("src")!="empty.jpg")&&
    (document.getElementById('a3').getAttribute("src")!="empty.jpg")&&
    (document.getElementById('b1').getAttribute("src")!="empty.jpg")&&
    (document.getElementById('b2').getAttribute("src")!="empty.jpg")&&
    (document.getElementById('b3').getAttribute("src")!="empty.jpg")&&
    (document.getElementById('c1').getAttribute("src")!="empty.jpg")&&
    (document.getElementById('c2').getAttribute("src")!="empty.jpg")&&
    (document.getElementById('c3').getAttribute("src")!="empty.jpg")
    )
    {
        document.getElementById('head').innerHTML="Standoff...";
        document.getElementById('status').innerHTML = "standoff";
        $(document).ready(function(){
            $("#new").fadeIn();
            $("#reset").fadeIn();
        });
        changePlayer();
    }
    else
    {
        changePlayer();
    }
    
}