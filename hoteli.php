
@extends('template')
@section('sadrzaj')
<style>
    .post_reply_comments::before{
        display: none;
    }
    ::before{
        display:none;
    }
</style>
<div id="afa">
    <section id="blog" class="container">
        <div class="center"><br>
            <h2>{{ $hotel->name }}</h2>
            <p class="lead">Pellentesque habitant morbi tristique senectus et netus et malesuada</p>
        </div>
        <ul class="pager">
  <li class="previous"><a href="{{url('country/'.$hotel->city->country->name.'/city' , $hotel->city->id )}}">prethodna</a></li>
 
</ul>
           <div class="row">
         <div class="col-md-8">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                         @foreach($hotel->picture as $k=> $picture)
                       @if($k==0)
                        <li data-target="#carousel-example-generic" data-slide-to="{{$k}}" class="active"></li>
                        @else
                        <li data-target="#carousel-example-generic" data-slide-to="{{$k}}"></li>
                        @endif
                       @endforeach
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" style="height: 500px">
                        @foreach($hotel->picture as $k=> $picture) 
                       @if($k==0)
                        <div class="item active">
                            @else
                             <div class="item">
                                 @endif
                                 <img class="img-responsive" width="800px"  src="{{asset('images/hotel/'.$hotel->id.'/'.$picture->picture )}}" alt="">
                        </div>
                       
                        @endforeach
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
            </div>
            
            </div>

        <div class="blog">
            <div class="row">
                <div class="col-md-8">
                    <div class="blog-item">
                        <img class="img-responsive img-blog" src="images/blog/blog1.jpg" width="100%" alt="" />
                            <div class="row">  
                                <div class="col-xs-12 col-sm-2 text-center">
                                    <div class="entry-meta">
                                        <span id="publish_date">07  NOV</span>
                                        <span><i class="fa fa-user"></i> <a href="#"> John Doe</a></span>
                                        <span><i class="fa fa-comment"></i> <a href="blog-item.html#comments">2 Comments</a></span>
                                        <span><i class="fa fa-heart"></i><a href="#">56 Likes</a></span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-10 blog-content">
                                    <h2></h2>
                                    <p>Curabitur quis libero leo, pharetra mattis eros. Praesent consequat libero eget dolor convallis vel rhoncus magna scelerisque. Donec nisl ante, elementum eget posuere a, consectetur a metus. Proin a adipiscing sapien. Suspendisse vehicula porta lectus vel semper. Nullam sapien elit, lacinia eu tristique non.posuere at mi. Morbi at turpis id urna ullamcorper ullamcorper.</p>

                                    <p>Curabitur quis libero leo, pharetra mattis eros. Praesent consequat libero eget dolor convallis vel rhoncus magna scelerisque. Donec nisl ante, elementum eget posuere a, consectetur a metus. Proin a adipiscing sapien. Suspendisse vehicula porta lectus vel semper.</p>

                                    <div class="post-tags">
                                        <strong>Tag:</strong> <a href="#">Cool</a> / <a href="#">Creative</a> / <a href="#">Dubttstep</a>
                                    </div>

                                </div>
                            </div>
                        </div><!--/.blog-item-->
                         <table class="table">
    <thead>
      <tr> 
          <th></th>
         
          @foreach($hotel->room as $room)
          <th>{{$room->name}}okrevetna</th>
          @endforeach
         
       
       
      
      </tr>
    </thead>
    @if(isset($hotel->period))
    <tbody>
        <?php $i=0; ?>
       @foreach($hotel->period as $period)
       
      <tr class="success">
        <th>{{date('d/m',strtotime($period->from))}}-{{date('d/m',strtotime($period->toto))}}</th>
      
        @foreach($hotel->room as $room)
        <td>   
             
            @foreach($hotel->service as $service)
          <?php  $i++; ?>
   {{$price=round(($period->periodKoef*$room->pivot->roomDiscount*$hotel->price))+$service->pivot->price}}-{{$service->name}} 
  {{($room->pivot->capacity)-($hotel->roomP()->where('room_id',$room->id)->where('period_id',$period->id)->first()->pivot->number) }}
            <br>
  @if(isset($hotel->roomP()->where('room_id',$room->id)->where('period_id',$period->id)->first()->pivot->number) && isset($room->pivot->capacity))
       
             <div id="dialog<?php  echo $i; ?>" title="REZERVISI" style="display:none;" >
  <p>Preostalo je jos  
  {{($room->pivot->capacity)-($hotel->roomP()->where('room_id',$room->id)->where('period_id',$period->id)->first()->pivot->number)  }}-
  {{$room->name}} krevetnih soba u ovom terminu. Rezervacija traje 5 dana, ukoliko ne potvrdite uplatom prve rate,
  automatski se skida rezervacija. Cena nocevanja je 
  {{round(($period->periodKoef*$room->pivot->roomDiscount*$hotel->price))+$service->pivot->price}} evra po osobi</p>
  @if(!empty(Auth::user()))
  <a href="{{url('rezervisi/'.$hotel->id.'/'.$room->id.'/'.$period->id.'/'.$service->id.'/'.$price)}}" style="float:left;"><button type="button" class="btn btn-success">REZERVISI</button></a>
   @else
  <a href="{{url('login')}}" style="float:left;"><button type="button" class="btn btn-success">Uloguj se</button></a> 
   @endif
  <a onclick="clo('#dialog<?php  echo $i; ?>')" style="float:right;" href="javascript:void(0);"><button type="button" class="btn btn-danger">odustani</button></a>
</div> 
          
            <a onclick="aaa('#dialog<?php  echo $i; ?>')" href="javascript:void(0);" id="rez"   >rezervisi<?php// echo $i; ?></a>
         
              @endif
            <br>
       
        @endforeach
        </td>
       
       @endforeach
      
      </tr>
       @endforeach
     
    </tbody>
    @endif
  </table>    
                      
                     
                        <p>* cene su u evrovima po osobi</p>
                        
                        <div class="media reply_section">
                            <div class="pull-left post_reply text-center">
                                <a href="#"><img src="images/blog/boy.png" class="img-circle" alt="" /></a>
                                <ul>
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus"></i> </a></li>
                                </ul>
                            </div>
                            <div class="media-body post_reply_content">
                                <h3>Antone L. Huges</h3>
                                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariaturp</p>
                                <p><strong>Web:</strong> <a href="http://www.shapebootstrap.net">www.shapebootstrap.net</a></p>
                            </div>
                        </div> <br><br>
                      <div class="responsive-vide">
                          <iframe width="600" height="315" src="{{$hotel->youtube}}" frameborder="0" allowfullscreen></iframe>
                      </div>
  
                        
                        
                        
                        <h1 id="comments_title">{{$hotel->brKomentara}} Comments</h1>
                        @foreach($hotel->comment->reverse()->take('2') as $i=> $comment)
                        <div class="media comment_section">
                            <div class="pull-left post_comments">
                                <a href="#"><img src="images/blog/girl.png" class="img-circle" alt="" /></a>
                            </div>
                            <div class="media-body post_reply_comments">
                                <h3>{{$comment->costumer[0]->name}}</h3>
                                <h4>{{date('d M, Y  h:m',strtotime($comment->created_at))}}</h4>
                              
                                <p>{{$comment->comment}}</p>
                                 @if(Auth::user())
                                 <button type="button" value="{{$comment->id}}" class="btn btn-success rep">Odgovori</button>
                               @endif
                            </div>
                        </div>
                          @if(!empty($comment->reply[0]))
                        <button type="button" class="btn btn-info" onclick="otvori('#reply<?php echo $i; ?>');"  >vidi odgovore</button><br><br>
                         <div style="display: none;" id="reply<?php echo $i; ?>">
                         <div id="odgovor{{$comment->id}}">
                         @foreach($comment->reply->where('status',2) as   $reply)
                       
                    <div id="repl{{$reply->id}}">
                  
                    <div  class="media comment_section">
                            <div class="pull-left post_comments">
                                
                                <a href="#"><img class="img-circle" style="width: 100px; " src="{{asset('images/costumers/'.$reply->costumer->id.'/'.$reply->costumer->image)}}" alt="logo"></a>
                            </div>
                            <div style="background:rgb(227, 223, 212);" class="media-body post_reply_comments">
                                 @if(isset($reply->costumer))
                                <h3>{{$reply->costumer->name}}</h3>
                                @endif
                             
                                <h4>{{date('d M, Y  h:m',strtotime($reply->created_at))}}</h4>
                              
                                <p>{{$reply->reply}}</p>
<!--                                 <a href="{{url('admin/delete/reply/'.$reply->id)}}">obrisi</a>-->
                              
                                
                                
                            </div>
                       
                         
                    </div>
                    </div>
                         <br> 
                    @endforeach
                         </div>
                         <button type="button" class="btn btn-danger " onclick="zatvori('#reply<?php echo $i; ?>')"  >zatvori</button>
                     </div> 
                        @endif
                        @if(Auth::check())
                         <div style="display:none;" id="odgovor_u{{$comment->id}}">
              <form  class="contact-form" name="contact-form" method="post"   >
<!--                                 <input type="hidden" name="_token" value="{{ csrf_token() }}">-->
<!--                                 zasto u ajaksu nece da cita input comment a u laravelu hoce, morao sam da ga saljem kroz rutu??  izadje null-->
                         <input type="hidden" name="kom" value="{{$comment->id}}">
                                
                                 <input id="name_u{{$comment->id}}" type="hidden"   value="{{Auth::user()->name}}">
                                 <input id="slika_u{{$comment->id}}" type="hidden"  value="{{Auth::user()->image}}">
                                 <input id="folder_u{{$comment->id}}" type="hidden"  value="{{Auth::user()->id}}">
                                 <input id="status_u{{$comment->id}}" type="hidden"  value="{{Auth::user()->admin}}">
                                <div class="row">

                                    <div class="col-sm-7">                        
                                        <div class="form-group">
                                            <label>Odgovor</label>
                                            <textarea name="reply" id="message_u{{$comment->id}}" required="required" class="form-control" rows="8"></textarea>
                                        </div>     
                                       
                                        <div class="form-group">
                   <button value="{{$comment->id}}" type="button"  class="btn btn-primary sacuvaj" >Odgovori</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
               <button class="btn btn-danger odustani" value="{{$comment->id}}"  >Odustani</button>
          </div>
                        @endif
                        @endforeach
                        
                   <a style="background: maroon;" href="{{url('country/'.$hotel->city->country->name.'/'.$hotel->city->name.'/'.$hotel->name.'/showcomment/'.$hotel->id)}}">   <button type="button" class="btn btn-primary">SVI KOMENTARI</button></a>  



                        <div id="contact-page clearfix">
                            <div class="status alert alert-success" style="display: none"></div>
                            <div class="message_heading">
                                <h4> </h4>
                                <p> </p>
                            </div> 
     
                        </div><!--/#contact-page-->
                         @if(Auth::user())

   
                         <button style="background:rgb(149, 154, 206);" id="btn-add" name="btn-add" class="btn btn-primary btn-xs">Napisi komentar</button>
   @endif
                    </div><!--/.col-md-8-->

                <aside class="col-md-4">
                    <div class="widget search">
                        <form role="form">
                                <input type="text" class="form-control search_box" autocomplete="off" placeholder="Search Here">
                        </form>
                    </div><!--/.search-->
    				
    				<div class="widget categories">
                        <h3>Recent Comments</h3>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="single_comments">
    								<img src="images/blog/avatar3.png" alt=""  />
    								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do </p>
                                    <div class="entry-meta small muted">
                                        <span>By <a href="#">Alex</a></span <span>On <a href="#">Creative</a></span>
                                    </div>
    							</div>
    							<div class="single_comments">
    								<img src="images/blog/avatar3.png" alt=""  />
    								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do </p>
    								<div class="entry-meta small muted">
                                        <span>By <a href="#">Alex</a></span <span>On <a href="#">Creative</a></span>
                                    </div>
    							</div>
    							<div class="single_comments">
    								<img src="images/blog/avatar3.png" alt=""  />
    								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do </p>
    								<div class="entry-meta small muted">
                                        <span>By <a href="#">Alex</a></span <span>On <a href="#">Creative</a></span>
                                    </div>
    							</div>
    							
                            </div>
                        </div>                     
                    </div><!--/.recent comments-->
                     

                    <div class="widget categories">
                        <h3>Categories</h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <ul class="blog_category">
                                    <li><a href="#">Computers <span class="badge">04</span></a></li>
                                    <li><a href="#">Smartphone <span class="badge">10</span></a></li>
                                    <li><a href="#">Gedgets <span class="badge">06</span></a></li>
                                    <li><a href="#">Technology <span class="badge">25</span></a></li>
                                </ul>
                            </div>
                        </div>                     
                    </div><!--/.categories-->
    				
    				<div class="widget archieve">
                        <h3>Archieve</h3>
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="blog_archieve">
                                    <li><a href="#"><i class="fa fa-angle-double-right"></i> December 2013 <span class="pull-right">(97)</span></a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right"></i> November 2013 <span class="pull-right">(32)</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right"></i> October 2013 <span class="pull-right">(19)</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right"></i> September 2013 <span class="pull-right">(08)</a></li>
                                </ul>
                            </div>
                        </div>                     
                    </div><!--/.archieve-->
    				
                    <div class="widget tags">
                        <h3>Tag Cloud</h3>
                        <ul class="tag-cloud">
                            <li><a class="btn btn-xs btn-primary" href="#">Apple</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">Barcelona</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">Office</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">Ipod</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">Stock</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">Race</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">London</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">Football</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">Porche</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">Gadgets</a></li>
                        </ul>
                    </div><!--/.tags-->
    				
    				<div class="widget blog_gallery">
                        <h3>Our Gallery</h3>
  
      	<iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d5806.002399671222!2d{{$hotel->lateral}}!3d{{$hotel->longitudinal}}!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ssr!2srs!4v1468630676629" width="400" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>             
                        
                    </div><!--/.blog_gallery-->
    					
    				
                </aside>     

            </div><!--/.row-->

         </div><!--/.blog-->

    </section><!--/#blog-->
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">KOMENTAR</h4>
                        </div>
                        <div class="modal-body">
                            <form id="frmTasks" name="frmTasks" class="form-horizontal" novalidate="">
                                <input id="hotel" type="hidden" name="hotel" value="{{$hotel->id}}">
                                <div class="form-group error">
                                   
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Komentar</label>
                                    <div class="col-sm-9">
                                        <textarea id="komentar" type="text" class="form-control"  name="comment" placeholder="Komentar" value=""></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" value="add">Posalji komentar</button>
                            <input type="hidden" id="task_id" name="task_id" value="0">
                        </div>
                    </div>
                </div>
            </div>
    </div>
       <script>
      function otvori(b){
   $( function() {
        $(b).fadeIn("slow");
        } );

};
      function zatvori(b){
   $( function() {
        $(b).fadeOut("slow");
        } );

};
    </script>  

 <script src="{{asset('js/comments.js')}}"></script>
@stop