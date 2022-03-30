<section class="book-list-easy">
    <div class="container">
        <div class="row box">

            <!-- starts : final a local class -->
            <div class="col-md-6 col-sm-12 box-sub find-class col-eq-height" style="min-height: 700px">
              <div class="find-class-text">
                <!-- starts : title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="title">ARE YOU LOOKING TO INSPIRE YOUR KIDS?</div>
                        <div class="sub-title">Classhub is full of ideas to help them realise their full potential.
                        </div>
                    </div>
                </div>
                <!-- end : title -->
                <!-- starts : title -->
                <div class="row content">
                    <div class="col-sm-12">
                        <!-- starts : list 01 -->
                        <dl>
                            <dt class="icon-browse">Simple to search</dt>
                            <dd>It’s quick and easy to list the classes near you, then simply book and pay online.</dd>
                        </dl>
                        <!-- end : list 01 -->
                        <!-- starts : list 02 -->
                        <dl>
                            <dt class="icon-wand">More choice</dt>
                            <dd>Choose from hundreds of hobbies, activities, music, sports, arts and crafts and academic
                                subjects.
                            </dd>
                        </dl>
                        <!-- end : list 02 -->
                        <!-- starts : list 03 -->
                        <dl>
                            <dt class="icon-check">Designed to suit your family</dt>
                            <dd>Help your kids achieve their goals in school, or find something they really love
                                after school.
                            </dd>
                        </dl>
                        <!-- end : list 03 -->
                    </div>
                </div>
                <!-- end : title -->
              </div>
                <!-- Starts: bottom button -->
                <div class="row class-button">
                    <div class="col-sm-12 text-center">
                        <a href="#" class="btn btn-primary" id="cta-search">
                            <span class="btn__text">FIND A LOCAL CLASS</span>
                        </a>
                    </div>
                </div>
                <!-- End: bottom button -->
            </div>
            <!-- end : final a local class -->

            <!-- starts : List your local class -->
            <div class="col-md-6 col-sm-12 box-sub list-class col-eq-height" style="min-height: 700px">
                <div class="find-class-text">
                <!-- starts : title -->
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="title">ARE YOU AN INSPIRING TEACHER?</div>
                          <div class="sub-title">Classhub makes it easy for you to share your knowledge and pass on skills
                              for life, in a way that suits you.
                          </div>
                      </div>
                  </div>
                  <!-- end : title -->
                  <!-- starts : title -->
                  <div class="row content">
                      <div class="col-sm-12">
                          <!-- starts : list 01 -->
                          <dl>
                              <dt class="icon-browse">Simple to be found</dt>
                              <dd>It’s quick and easy to list the classes you teach, and get booked up and paid online.
                              </dd>
                          </dl>
                          <!-- end : list 01 -->
                          <!-- starts : list 02 -->
                          <dl>
                              <dt class="icon-wand">More control</dt>
                              <dd>You choose to when and how you teach to fit in with your life, and you engage directly
                                  with your students.
                              </dd>
                          </dl>
                          <!-- end : list 02 -->
                          <!-- starts : list 03 -->
                          <dl>
                              <dt class="icon-check">Designed to change lives</dt>
                              <dd>Build confidence, boost brains and help create well rounded, happy, curious young
                                  people.
                              </dd>
                          </dl>
                          <!-- end : list 03 -->
                      </div>
                  </div>
                  <!-- end : title -->
                </div>
                  <!-- Starts: bottom button -->
                  <div class="row class-button">
                      <div class="col-sm-12 text-center">
                          <a href="{{ Auth::user() ? route('educator.lesson.create') : 'javascript:;' }}"
                             {{ !Auth::user() ? 'data-toggle=modal data-target=#login-modal' : '' }}
                             class="btn btn-primary">
                              <span class="btn__text">LIST YOUR LOCAL CLASS</span>
                          </a>
                      </div>
                  </div>
                  <!-- End: bottom button -->
            </div>
            <!-- end : List your local class -->

        </div>
    </div>
</section>

<script type="text/javascript">
    $(function(){
        $('a#cta-search').on('click', function(){
            $('html, body').animate({ scrollTop: 0}, 'fast')
        })
    })
</script>
