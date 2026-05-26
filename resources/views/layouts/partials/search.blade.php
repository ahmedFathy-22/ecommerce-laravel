<div class="search-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12"> <span class="close-btn"><i class="fas fa-window-close"></i></span>
                    <div class="search-bar">
                        <div class="search-bar-tablecell">
                            <form action="{{ route('products.search') }}" method="GET"
                                style="position:relative; max-width:550px; margin:auto;">
                                <div style="position:relative;"> <input type="text" id="search-input"
                                        name="q" placeholder="Search for products..." autocomplete="off"
                                        style=" width:100%; height:60px; padding:0 60px 0 25px; border:none; border-radius:50px; background:white; font-size:18px; font-weight:500; color:#051922; box-shadow:0 10px 30px rgba(0,0,0,0.15); transition:0.3s; outline:none; "
                                        onfocus=" this.style.boxShadow='0 10px 35px rgba(242,129,35,0.4)'; "
                                        onblur=" this.style.boxShadow='0 10px 30px rgba(0,0,0,0.15)'; "> <button
                                        type="submit"
                                        style=" position:absolute; right:8px; top:50%; transform:translateY(-50%); height:45px; padding:0 25px; border:none; border-radius:30px; background:#F28123; color:white; font-weight:600; cursor:pointer; transition:0.3s; "
                                        onmouseover=" this.style.background='#051922'; "
                                        onmouseout=" this.style.background='#F28123'; "> 🔍 Search </button> </div>
                                <div id="search-results"
                                    style=" position:absolute; top:70px; left:0; width:100%; background:white; border-radius:20px; overflow-y:scroll; z-index:9999; display:none; box-shadow:0 15px 40px rgba(0,0,0,0.2); height:auto; min-height:100px; max-height:60vh; ">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

