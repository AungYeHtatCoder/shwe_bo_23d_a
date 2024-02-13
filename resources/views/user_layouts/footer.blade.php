                <!-- footer -->
                <footer id="footer" class="fixed-bottom">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 offset-lg-3 offset-md-3 col-12 footer-border-purple pt-3 pb-1 footer-border">
                            <div class="row">
                                <div class="col-4">
                                    <a href="{{ route('welcome') }}" class="text-decoration-none d-block footer-link {{ Route::currentRouteNamed('welcome') ? 'active' : '' }}">
                                        <i class="fas fa-home"></i>
                                        <small class="mt-2 d-block" style="font-size: 12px;">ပင်မ</small>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a href="{{ route('promotion') }}" class="text-decoration-none d-block footer-link {{ Route::currentRouteNamed('promotion') ? 'active' : '' }}">
                                        <i class="fas fa-gift"></i>
                                        <small class="mt-2 d-block" style="font-size: 12px;">ပရိုမိုရှင်း</small>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a href="{{ route('profile') }}" class="text-decoration-none d-block footer-link {{ Route::currentRouteNamed('profile') ? 'active' : '' }}">
                                        <i class="fas fa-user"></i>
                                        <small class="mt-2 d-block" style="font-size: 12px;">ကျွန်ုပ်</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- footer -->

