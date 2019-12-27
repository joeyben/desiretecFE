@extends('frontend.layouts.newapp')

<section class="section-top">

<div class="img-background">
    <div class="container">
        <div class="col-md-8 bg-left-content">
            <h3>Hallo Johannes ,</h3>
            <p>Dein Reisewunsch wurde am <b>&#60;Datum&#62;</b> an <b>&#60;Reiseburoname&#62;</b> <br>
            ubermittelt. Leider liegt momentan noch kein Angebot vor.</p>

            <button class="primary-btn" data-toggle="modal" data-target="#myModal">Reiseburo kontaktieren</button>
            <button class="secondary-btn"data-toggle="modal" data-target="#myModal2">Ruckrufbitte einstellen</button>
        </div>
    </div>
</div>

<div class="bg-bottom">
<div class="container">
        <h4>Zustandiges Reiseburo</h4>
        <div class="col-md-3">
            <p>
            Reiseburo Sonnenklar</p>
            <p>
            Musterstrasse 7 <br>
            12345 Wusterhausen
            </p>
        </div>
        <div class="col-md-3 c-info">
            <i class="glyphicon glyphicon-user"></i>
            <span>Name Ansprechpartner</span>
        </div>
        <div class="col-md-3 c-info c-tel">
            <i class="glyphicon glyphicon-earphone"></i>
            <a href="tel:08971459535">089 - 714 595 35</a>
        </div>
        <div class="col-md-3 c-info">
            <i class="glyphicon glyphicon-envelope"></i>
            <a href="mailto:mail@reisebuero.de">mail@reisebuero.de</a>
        </div>
    </div>
</div>
</section>

<div class="container">
    <div class="col-md-12 hr"><hr></div>
</div>
<section class="section-angebote-2">
        <div class="container">
        <div class="col-md-12 sa2-1">
        <h4>
          Neue Angebote
        </h4>
        <p class="sa2-p1">Du hast 3 Angebote von <b>&#60;Reiseburoname&#62;</b> erhalten</p>
        <p class="sa2-p2">
        Moin Johannes, <br><br>
        Wir haben entsprechend deinen Reisewunchen Angebote fur dich zisammengestellt.
        <br><br>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec purus libero, tempor eget mi vel, 
        pellentesque sodales dui. Nam pharetra neque et nibh vehicula, ut rutrum orci varius. 
        In quis sapien non turpis fermentum venenatis quis sed felis. Sed commodo scelerisque metus.
        <br><br>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec purus libero, tempor eget mi vel, 
        pellentesque sodales dui. Nam pharetra neque et nibh vehicula, ut rutrum orci varius. 
        In quis sapien non turpis fermentum venenatis quis sed felis. Sed commodo scelerisque metus.
        <br><br>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec purus libero, tempor eget mi vel, 
        pellentesque sodales dui. Nam pharetra neque et nibh vehicula, ut rutrum orci varius. 
        In quis sapien non turpis fermentum venenatis quis sed felis. Sed commodo scelerisque metus.
        <br><br>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec purus libero, tempor eget mi vel, 
        pellentesque sodales dui. Nam pharetra neque et nibh vehicula, ut rutrum orci varius. 
        In quis sapien non turpis fermentum venenatis quis sed felis. Sed commodo scelerisque metus.
        </p>
        <div class="sa2-buttons">
          <button class="primary-btn">Reiseburo kontaktieren</button>
          <button class="secondary-btn">Ruckrufbitte einstellen</button>
        </div>
        </div>
        </div>
</section>

<div class="container">
    <div class="col-md-12 hr"><hr></div>
</div>
<section class="section-comments">
    <div class="container">
        <div class="col-md-12">
        <h4>
        Nachrichten
        </h4>
        
        <div class="cu-img-left">
            <img src="/img/frontend/profile-picture/white.jpeg" alt="">
        </div>

        <div class="cu-comment-left">
            <p>
            <span>14.01.19 - 8:53 Uhr</span>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        Lorem ipsum dolor sit amet, consectetur adipisicing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
        </div>
        

        </div>

        <div class="col-md-12">

        <div class="cu-img-right">
            <img src="/img/frontend/profile-picture/white.jpeg" alt="">
          </div>      
      
        <div class="cu-comment-right">
            <p>
            <span>14.01.19 - 8:53 Uhr</span>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        Lorem ipsum dolor sit amet, consectetur adipisicing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
          <div class="cu-cr-buttons">
            <button class="secondary-btn"> Neue Nachricht</button>
          </div>

        </div>  
      </div>

    </div>
</section>
<div class="container">
    <div class="col-md-12 hr hr-mobile"><hr></div>
</div>

<section class="section-contact">
    <div class="container">

    <div class="col-md-12 s2-first">
    <h4>Dein Reisewunsch</h4>
    <p class="sc-first-p">Dies sind Deine Angaben zu Deinem Reisewunsch.</p>
    <p><b>Deine Nachricht:</b><br>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec purus libero, tempor eget mi vel, 
    pellentesque sodales dui. Nam pharetra neque et nibh vehicula, ut rutrum orci varius. 
    In quis sapien non turpis fermentum venenatis quis sed felis. Sed commodo scelerisque metus, consequat tempor turpis consectetur nec. Nullam a fermentum dolor.
    </p>
    </div>

    <div class="col-md-12 s2-second">

        <div class="col-md-3">
        <span class="circle"></span>
        <input class="data-content" value="Hamburg">
        </div>
        <div class="col-md-3">
        <span class="circle"></span>
        <input class="data-content" value="17.01 - 17.04.19">
        </div>
        <div class="col-md-3">
        <span class="circle"></span>
        <input class="data-content" value="3.094€">
        </div>
        <div class="col-md-3">
        <span class="circle"></span>
        <input class="data-content" value="4 Sterne">
        </div>

        <div class="col-md-3">
        <span class="circle"></span>
        <input class="data-content" value="Gran Canaria">
        </div>
        <div class="col-md-3">
        <span class="circle"></span>
        <input class="data-content" value="2 Etwachsene">
        </div>
        <div class="col-md-3">
        <span class="circle"></span>
        <input class="data-content" value="Genau 10 Tage">
        </div>
        <div class="col-md-3">
        <span class="circle"></span>
        <input class="data-content" value="Halbpension">
        </div>
        <button class="secondary-btn">Daten andern</button>
    </div>

    </div>

</section>

<section class="section-contact-mobile">
    <div class="container">

<div class="panel-group" id="accordion1">
<div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion1" href="#content">
          <div class="col-md-12 s2-first">
          <h4>Dein Reisewunsch</h4>
          <p>Dies sind Deine Angaben zu Deinem Reisewunsch.</p>
          </div>
          <span class="glyphicon glyphicon-plus"></span></a>
          <span class="glyphicon glyphicon-minus"></span></a>
        </h4>
      </div>

    <div id="content" class="panel-collapse collapse">
        <div class="panel-body">
        <div class="col-md-12 s2-first">
          <p><b>Deine Nachricht:</b><br>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec purus libero, tempor eget mi vel, 
          pellentesque sodales dui. Nam pharetra neque et nibh vehicula, ut rutrum orci varius. 
          In quis sapien non turpis fermentum venenatis quis sed felis. Sed commodo scelerisque metus, consequat tempor turpis consectetur nec. Nullam a fermentum dolor.
          </p>
          </div>
        <div class="col-md-12 s2-second">
        <div class="col-md-3">
        <span class="circle"></span>
        <input class="data-content" value="Hamburg">
        </div>
        <div class="col-md-3">
        <span class="circle"></span>
        <input class="data-content" value="17.01 - 17.04.19">
        </div>
        <div class="col-md-3">
        <span class="circle"></span>
        <input class="data-content" value="3.094€">
        </div>
        <div class="col-md-3">
        <span class="circle"></span>
        <input class="data-content" value="4 Sterne">
        </div>

        <div class="col-md-3">
        <span class="circle"></span>
        <input class="data-content" value="Gran Canaria">
        </div>
        <div class="col-md-3">
        <span class="circle"></span>
        <input class="data-content" value="2 Etwachsene">
        </div>
        <div class="col-md-3">
        <span class="circle"></span>
        <input class="data-content" value="Genau 10 Tage">
        </div>
        <div class="col-md-3">
        <span class="circle"></span>
        <input class="data-content" value="Halbpension">
        </div>
        <button class="secondary-btn">Daten andern</button>
        </div>


        </div>
      </div>
    </div>
</div>

    </div>
</section>


<div class="container">
    <div class="col-md-12 hr hr-mobile"><hr></div>
</div>

<section class="section-data">
    <div class="container">
        <div class="col-md-6 s3-left s3-left-show">
            <h4>Haufige Fragen anderer Nutzer</h4>
            <span><hr></span>
            <p>
                Ihre Frage ist nicht dabei? <br>
                <b><a href="mailto:service@desirectec.de">service@desirectec.de</a></b>
            </p>
        </div>
        <div class="col-md-6 s3-right">
        <div class="panel-group" id="accordion">
        <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">&#60;Haufig festellte Frage 1 - Lorem ipsum dolor&#62; <span class="glyphicon glyphicon-minus"></span><span class="glyphicon glyphicon-plus"></span></a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse">
        <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">&#60;Haufig festellte Frage 2 - Lorem ipsum dolor&#62; <span class="glyphicon glyphicon-minus"></span><span class="glyphicon glyphicon-plus"></span></a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">&#60;Haufig festellte Frage 3 - Lorem ipsum dolor&#62; <span class="glyphicon glyphicon-minus"></span><span class="glyphicon glyphicon-plus"></span></a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">&#60;Haufig festellte Frage 3 - Lorem ipsum dolor&#62; <span class="glyphicon glyphicon-minus"></span><span class="glyphicon glyphicon-plus"></span></a>
        </h4>
      </div>
      <div id="collapse4" class="panel-collapse collapse">
        <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
      </div>
    </div>

    </div> 
    </div>

    <div class="col-md-12 s3-left s3-left-hidden">
            <span><hr></span>
            <p>
                Ihre Frage ist nicht dabei? <br>
                <b><a href="mailto:service@desirectec.de">service@desirectec.de</a></b>
            </p>
        </div>

    </div>
</section>
