<div class="main" style="background-image: url('{{asset('public/images/temp/Background.jpg')}}');   
	background-position: center;
    background-repeat: no-repeat;
    background-size: 100%;
    width: 80%;
    margin: 0 auto;" >
	<div class="mail-wrap">
		<div class="container">
			<div class="content" style="position: relative;">
				<div style="padding: 15px 50px 26px;">
					<h2 style="color: #fff;">Dear {{ $data['fullName'] }}</h2>
					<div class="desc" style="position: relative; color: #fff;font-size: 20px;text-align: left;">
						Greetings from Sonasia Holiday! This email is to confirm that we have received
						your inquiry.<br><br>

						One of our travel consultant will contact with you within 24 hours to give you the
						first proposal based on the information you gave us. In the meantime, you can
						continue to surf our website again following the links below.<br><br>

						Wish you all the best.<br><br>

						Yours faithfully,<br>
						BiiG Holiday team
						<div style="text-align: right;">
							<img src="{{asset('public/images/Bee.png')}}">
						</div>
					</div>
					<ul class="all_link" style="display: flex;flex-wrap: wrap;padding-left: 0;margin-top: 50px;list-style-type: none;font-size: 24px;margin: 1px 0;">
						<li style="width: 33%;; text-align: left;"><a href="http://sonasia-holiday.com/asia-tour-packages" style="color: #f3bb38; text-decoration: none;">View all tours</a></li>
						<li style="width: 33%;; text-align: center;"><a href="{{route('home')}}" style="color: #f3bb38; text-decoration: none;">Learn about our destinations</a></li>
						<li style="width: 33%;; text-align: right;"><a href="{{route('aboutPage')}}" style="color: #f3bb38; text-decoration: none;">Sonasia Holiday</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>