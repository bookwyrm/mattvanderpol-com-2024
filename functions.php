<?php

if (! file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'sage'));
}
require $composer;
TailCraft\Theme\Init::run();

add_filter('body_class', function($classes) {
    if ( $_SERVER['SERVER_NAME'] === 'localhost' ) {
        $classes[]= 'debug-screens';
    }
    return $classes;
});

// Push Yoast SEO metabox to bottom
// Based on: https://gist.github.com/ramseyp/6920038
add_filter( 'wpseo_metabox_prio', function() { return 'low'; } );



	function mv_2024_the_posts_navigation() {
		the_posts_pagination(
			array(
				'before_page_number' => esc_html__( 'Page', 'twentytwentyone' ) . ' ',
				'mid_size'           => 0,
				'prev_text'          => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					is_rtl() ? '&gt;' : '&lt;',
					wp_kses(
						__( 'Newer <span class="nav-short">posts</span>', 'twentytwentyone' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					)
				),
				'next_text'          => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					wp_kses(
						__( 'Older <span class="nav-short">posts</span>', 'twentytwentyone' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					is_rtl() ? '&lt;' : '&gt;'
				),
			)
		);
	}

add_shortcode('house_icon', function() {
    return '<svg height="40" viewBox="0 0 42 40" width="42" xmlns="http://www.w3.org/2000/svg"><path d="m41.545 12.7719298-18.865-12.5964912c-.175-.10526316-.385-.1754386-.595-.1754386h-1.785c-.21 0-.42.07017544-.595.1754386l-19.25 12.8070175c-.28.2105264-.455.5263158-.455.877193v6.877193c0 .3859649.21.7368421.56.9473684.14.0701755.315.1052632.49.1052632.21 0 .42-.0701755.595-.1754386l2.555-1.7894737v19.122807c0 .5964912.455 1.0526316 1.05 1.0526316h7.35 4.2 8.4 4.2 7.35c.595 0 1.05-.4561404 1.05-1.0526316v-19.3333333l2.555 1.7894737c.315.2105263.735.245614 1.085.0701754s.56-.5263158.56-.9473684v-6.877193c0-.3508772-.175-.6666667-.455-.877193zm-32.095 11.4385965c0-.5964912.455-1.0526316 1.05-1.0526316h6.3c.595 0 1.05.4561404 1.05 1.0526316s-.455 1.0526316-1.05 1.0526316h-6.3c-.595 0-1.05-.4561404-1.05-1.0526316zm0-4.2105263c0-.5964912.455-1.0526316 1.05-1.0526316h6.3c.595 0 1.05.4561404 1.05 1.0526316s-.455 1.0526316-1.05 1.0526316h-6.3c-.595 0-1.05-.4561404-1.05-1.0526316zm7.35 17.8947368v-7.368421c0-.5964912.455-1.0526316 1.05-1.0526316h6.3c.595 0 1.05.4561404 1.05 1.0526316v7.368421zm14.7-12.6315789h-6.3c-.595 0-1.05-.4561404-1.05-1.0526316s.455-1.0526316 1.05-1.0526316h6.3c.595 0 1.05.4561404 1.05 1.0526316s-.455 1.0526316-1.05 1.0526316zm0-4.2105263h-6.3c-.595 0-1.05-.4561404-1.05-1.0526316s.455-1.0526316 1.05-1.0526316h6.3c.595 0 1.05.4561404 1.05 1.0526316s-.455 1.0526316-1.05 1.0526316zm8.4-2.5614035-17.22-12.00000003c-.175-.10526316-.385-.1754386-.595-.1754386h-1.785c-.21 0-.42.07017544-.595.1754386l-17.605 12.24561403v-4.2807017l18.515-12.35087724h1.155l18.13 12.10526314z"/></svg>';
});
add_shortcode('rms_logomark', function() {
    return '<svg height="40" viewBox="0 0 29 40" width="29" xmlns="http://www.w3.org/2000/svg"><g><path d="m11.3767326 25.838167c-.9093428.7182943-1.71197547 1.196699-2.40789811 1.4352142-.69592264.2385151-1.73329228.3907386-3.11210892.4566703-1.25285501-.1977649-2.07531459-.3499883-2.46737874-.4566703-2.30072725-.626036-.67102603-4.4423251-2.4832399-5.304865-1.20814258-.5750266-1.20814258-2.0988622 0-4.5715067.37964814-.6902287.7584752-1.1326067 1.13648117-1.3271341 2.19466899-1.1294085 4.21705279-1.4635768 4.56907878-1.7340234.2964551-.2277538 1.06788684-.3927538 1.29073474-.8923647.33221083-.7447957.20829654-1.9322281 1.62175284-2.7547514 2.36160654-1.37427418 1.31195934-4.46683056 2.04170904-5.2819473.4864998-.54341116 1.0822292-1.20781685 1.7871884-1.99321705.5004312-.3157158 1.1022854-.69293614 1.8055628-1.13166101.7032774-.43872488 1.5624923-.79921187 2.5776448-1.08146097l4.2509185-1.08196908c1.1096248-.15797399 2.0360812-.15797399 2.7793692 0 1.8089235.38445777.9679583 1.75664526 1.8798612 2.87817265.1675913.20611643.7925941.98858347 1.5011585 3.2252522.110019.34728822.2274117 1.06960265.3521781 2.1669433v3.88754446c.6670067 2.9333029.6670067 4.6401751 0 5.1206164-.6670067.4804414-1.4075599.8789038-2.2216595 1.1953872l-3.6548543.8299011c-.5142087.216869-.9376574.4229286-1.270346.6181788-.3326886.1952501-.6489128.4232939-.9486726.6841312l-2.6679531 1.8161891c-.1438027.1740017-.6589665.2965799-1.5454913.3677346-.8865248.0711548-1.8985764.0711548-3.0361548 0-.1497998-.1385289-.3875129.0604941-.7131392.5970691s-.6805402 1.3140971-1.0647416 2.3325664z"/><path d="m18.8452287 17.9433536-.3905709 4.6317211c-.1504242.874271-.2981226 1.4881757-.4430951 1.841714-.1449725.3535384-.4171228.7635015-.816451 1.2298891l-1.5455397-1.2298891c-.2629194-.267502-.4416025-.4939352-.5360493-.6792995-.227782-.4470526-.3474416-1.0488541-.5388765-1.4970419-.3104987-.7269403-.6239166-1.5741411-.9402538-2.5416022-.5245648-1.2230321-.9133764-2.1449965-1.1664349-2.7658934-.2530586-.6208968-.3610705-.917924-.3240359-.8910815l-.7486596.2532712c.193643.3759502.3827242.7857156.5672435 1.2292963.1845192.4435807.4732876 1.182556.8663051 2.216926.2840733.8969486.5378569 1.6349881.7613508 2.2141184.2234939.5791304.5800224 1.422567 1.0695854 2.5303097l-3.1409333-.8644099c-.3967579-.0092784-.6915054-.0092784-.8842426 0-.1927371.0092784-.4017034.0335272-.6268987.0727464-.09328862-.0229568-.17158289-.0472056-.23488281-.0727464s-.13568835-.0620908-.2171653-.10965c-.38411705.0060116-.6758593-.0282924-.87522673-.1029119-.19936744-.0746194-.46246007-.2479797-.7892779-.5200809-.49637051-.4549735-.92146537-.9054898-1.27528461-1.351549-.35381923-.4460592-.79551119-1.0882992-1.32507587-1.9267201l-.99723888-.1956542.89985534 1.9425671c.50115096.6251005.86961678 1.1124372 1.10539745 1.46201.22136453.3281992.52463679.8360901.91461994 1.5182233.0169315.0296154.04348684.073881.07966602.1327965.55128203.1861483.95461744.3205982 1.21000622.4033497.19318179.0625951.44010583.1855107.80463937.2786014.07825628.0199843.21516917.0365176.41073865.0495999.01782232-.0136631.15832688-.0301964.42151371-.0495999.2631867-.0194034.5916415-.0618597.9853643-.1273686 1.1458659.2511702 1.9782857.4756277 2.4972596.6733725s1.0447194.4907894 1.5772364.8791339c.2195935.2201664.3609986.4176507.4242153.592453s.0849238.4283438.0651213.7606246l-.3562981 2.7181028c-.0210879 2.1676543-.0491825 3.8173327-.0842839 4.9490352-.0351014 1.1317026-.0905576 2.1757846-.1663688 3.132246-.0321316.2944663-.0984467.5361538-.1989451.7250624-.1004985.1889086-.2594012.3705667-.4767082.5449744h4.5005228c-.0004323-.0477367-.0210469-.1011111-.0618437-.1601233-.0407969-.0590121-.101426-.1231557-.1818874-.1924307m-.0027644-.0045961c-.3937909-.1742949-.6701089-.6648031-.8289538-1.4715245-.158845-.8067214-.2570453-2.2182686-.294601-4.2346415-.0332491-2.2036665-.0332491-3.6262567 0-4.2677705s.1314494-1.113617.294601-1.4163096c.1829554-.402025.3226642-.6870421.4191262-.8550514.397063-.6915708.7308844-1.1707372.8680015-1.4853439.5855282-1.3434585.6347836-2.0693118.6347836-2.0693118s.0968977-.4847658.1265986-.9316349c.016401-.2467647.1713221-1.0990015.1796255-1.4972603.0128302-.6153786-.1020554-.969927 0-1.8913763.0396915-.3583711.1471694-.8103121.3224338-1.3558227l.3216543-.5060407 1.4155174-1.1339048.9368666-1.1196395 1.1753623-2.4148865c.1519653-.3198673.2702542-.5495166.3548668-.6889479.0846125-.1394312.2092586-.3101095.3739382-.5120348l-.4547226-.2507937c-.1519849.2438182-.2772892.4412648-.375913.5923397s-.1730557.2595903-.2232956.3255462l-.4370385.8495939c.0379463-.0447125.0137192.0446436-.0726813.2680683-.0864004.2234248-.2365404.5849683-.45042 1.0846307-.0761017.2070538-.20024.4210764-.3724149.6420679-.172175.2209915-.4655571.5428684-.8801464.9656306-.2051253.2076503-.38336.3633045-.534704.4669627s-.3818386.22795-.6914838.3728753c.0131701-.1984518.0631805-.3922561.1500313-.5814129.3019153-.6575569.8061934-1.5349982.933971-1.9664313.1829135-.6175961.2985273-1.0109662.3468413-1.1801103.1667549-.8003647.2907046-1.4825106.3718493-2.0464377.0811446-.5639271.1518471-1.300646.2121076-2.2101567l.3130876-3.87932807-1.1017003-.08676317c.0667114.40527091.0667114 1.04761705 0 1.92703842-.0667113.87942137-.1832666 1.77356237-.3496657 2.68242299-.1017704.72043713-.2137961 1.35329553-.336077 1.89857523-.0427599.1906765-.1116908.5854695-.1750705.8354922-.0785785.3099799-.2268162.819427-.4447131 1.5283413l-.9260378 1.943521-.2547826-3.8401266.164135-2.36580313.0906476-1.19582282-.5341484-.12309877-.2306798 3.50703582c.0851738 1.0095413.1343332 1.7681526.1474784 2.2758337.0131451.5076811.0131451.9490573 0 1.3241287l.0832014 1.2276861c.0110659.0988179.0110659.226349 0 .3825932-.0110659.1562443-.0387997.4202984-.0832014.7921626"/></g></svg>';
});
