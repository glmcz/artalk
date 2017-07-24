<?php get_header();   ?>
    <div class="row">
        <article>
            <div class="col-md-8 no-margin text_width ">

				<?php
//
//				$html->find('div[id=hello]', 0)->innertext = 'foo';
//				echo $html; // Output: <div id="hello">foo</div><div id="world" class="bar">World</div>
				//				$html = file_get_contents('http://www.tibia.com/community/?subtopic=worlds&world=Aurora');
//				$html2 = ('http://www.tibia.com/community/?subtopic=characters&name=Aarkanito');
//				$html = file_get_contents('http://git/2015/07/13/16-7-2015-letne-kino-v-sng/');
//
//				$dom = new domDocument;
//				$xpath = new domXpath($dom);
//				$dom->loadHTML($htm);
//
//				$a2 = $xpath->query('[@id="characters"]/div[5]/div/div/table[3]/tbody/tr[2]/td[1]');
//				$a2 = $a2[0];
//				echo "Latest death: " . $a2;

				// Create DOM from URL or file
//				$html = "";
//				$html = file_get_html('http://git/2015/07/13/16-7-2015-letne-kino-v-sng/');
//
//				// Find all images
//				foreach($html->find('img') as $element)
//					echo $element->src . '<br>';
//
//				// Find all links
//				foreach($html->find('a') as $element)
////					echo $element->href . '<br>';

//				$html = '<html><body><div><p>p1</p><p>p2</p></div></body></html>';
//				$dom = new DOMDocument('1.0','UTF-8');
//				$dom->loadHTML('<html><body><div><p>p1</p><p>p2</p></div></body></html>');
//				$node = $dom->getElementsByTagName('div')->item(0);
//				$outerHTML = $node->ownerDocument->saveHTML($node);
//				$innerHTML = '';
//				foreach ($node->childNodes as $childNode){
//					$innerHTML .= $childNode->ownerDocument->saveHTML($childNode);
//				}
//				echo '<h2>outerHTML: </h2>';
//				echo htmlspecialchars($outerHTML);
//				echo '<h2>innerHTML: </h2>';
//				echo htmlspecialchars($innerHTML);

//				$doc = new DOMDocument();
//				libxml_use_internal_errors(true);
//				$doc->loadHTML($html); // loads your HTML
//				$xpath = new DOMXPath($doc);
				// returns a list of all links with rel=nofollow
//				$nlist = $xpath->query("//a[@rel='nofollow']");
//				$nlist =
//                    $xpath->query("//a");
//				echo $nlist->item(12);
//				echo "{$node->nodeName} - {$node->nodeValue}";
//				var_dump(
//					$xpath->evaluate('string(a)')
//				);

//				foreach($html->find(' a [href=#_ftnref1] ') as $element) {
//					echo $element->parent () . '<br>';
//				}

//               !!!!!!!!!!!!!!!dostaneme citace pod clankem
//				foreach($html->find(' * [href^=#_ftnref] ') as $element) {
//					echo $element->parent () . '<br>';

//				 $ftn = $element->parent ();
//                    foreach($ftn->find(' * [href^=#_ftnref]') as $eleme) {
//	                    echo $eleme->plainText;
//	                    echo $eleme->parent() . '<br>';
//                    }
//
//				}


//
//                    echo $el - $no;
//                    echo $end = str_replace($el, '', $no).'<br>';
//                    foreach (($end) as $n){
//                        echo $n. '<br>';
//                    }
//					foreach ($a->find('a[name!=_ftnref]') as $no) {
//						echo "naaaaaaae";
//						echo $no;
//					}

//				foreach($html->find('* [href^=#_ftnref]') as $elemen) {
////					echo $elemen->parent () . '<br>';
//					$ftn = $elemen->parent ();
////					echo $ftn->first_child ()  ;
////					echo $ftn->last_child ()  ;
//
//					echo $ftn->prev_sibling ()  ;
////					$ftn->children([0]);
//                    $ftn->children(1);
//					echo $ftn->children(1)->innertext;
//                    $int++;
//					foreach as $element)
//						echo $element->href . '<br>';
//					    $int++;
//					foreach ($ftn->children([1]) as $tag){
//					    echo $tag->parent ();
//					    echo "saaaaaaaaaaaaaaaaaaa";
//                    }
//					echo $elemen-> outertext .  '<br>';
//					echo $elemen-> innertext .  '<br>';
//					echo $elemen-> attribute .  '<br>';
//					echo $elemen->next_sibling () . '<br>';
//				}
//					echo $element-> outertext .  '<br>';
//					echo $element-> innertext .  '<br>';
//					echo $element-> attribute .  '<br>';
//					echo $element->next_sibling () . '<br>';

//					foreach( $element->innertext as $ar){
//						echo $ar->find( 'a [href=#_ftnref1]');
//						echo $ar . '<br>';
//
//						echo "ewwwwwwwwwwwww";
//					}

//                echo $html->getElementByTagName(' p a ');
//                echo "e";
//				foreach($html->find('* ['name=_ftnref']') as $element) {
////					echo $element-> outertext .  '<br>';
//				   foreach($element->find('  a [name=_ftn3] ') as $element) {
//					echo $element-> outertext .  '<br>';
//					echo $element-> innertext .  '<br>';
//				   }
//					echo $element-> attribute .  '<br>';
//					echo $element-> innertext .  '<br>';
//					echo $element-> attribute .  '<br>';
//					echo $element->next_sibling () . '<br>';
//					echo $element->prev_sibling () . '<br>';
//
//					foreach( $element->firstChild () as $ar){
//						echo $ar-> outertext .  '<br>';
//						echo $ar-> innertext .  '<br>';
//						echo $ar> attribute .  '<br>';
//						echo "ewwwwwwwwwwwww";
//					}
//				}

				if (have_posts()) : while (have_posts()) : the_post();
				?>


                <h1><?php the_title(); ?></h1>

                <!--                --><?php //$var = '600';echo get_the_content_reformatted($var);?>


                <div class="post-meta-single ">
                    <span><?php the_author_posts_link(); ?></span> | <span><?php the_time( get_option( 'date_format' ) ); ?></span>
                    <span><?php edit_post_link( 'edit', ' | ' ); ?></span> <span> RECENZE - </span> <span><?php do_action('artalk_post_cats'); ?></span>
                </div>


                <div class="col-md-9 col_9_padding_single_right">
					<?php
					$c = get_the_content_with_formatting();
					//                echo $c;
					$html = "";
					// Create DOM from string
					$html = str_get_html($c);
					//global
					$citate_string = "";
//					find citate text under post
                    $val = array();
					foreach($html->find(' * [href^=#_ftnref] ') as $element) {
						echo $element->parent() . '<br>';
						$val[] = $element->parent(); //array push nefunguje

					}
//					!!!!!!!!!!!!!!!!!!!!!!!!!! anchors from text content

                    foreach ($html->find('p a[name^=_ftn]') as $el) {
                        $a = str_get_html( $el );
                        foreach ( $a->find( 'a[name^=_ftnref]' ) as $no ) {

                            echo $no->outertext;
                            $citate_string = $citate_string . $no->outertext;
	                        echo "sem dat text z citaci a potom je vycentrovat bokem vedle";

                        }
                    }
//
//                  deleted matched citate text under post
					$cont = "";
					for ($i = 0; $i < count($val);$i++){
					$cont = get_the_content_with_formatting($val[$i],$cont,"","","") ;
//                    echo $val[$i];
//                    echo "vvv";
//the_content();
                    }
                    echo $cont;

					?>
                    <!--	              --><?php
					//
					//	              $phrase = get_the_content();
					//	              // This is where wordpress filters the content text and adds paragraphs
					//	              $phrase = apply_filters('the_content', $phrase);
					//	              $replace = '<p style="text-align: left;font-family: Georgia, Times, serif; font-size: 14px; line-height: 22px; color: #1b3d52; font-weight: normal; margin: 15px 0px; font-style: italic;">';
					//
					//	              echo str_replace('<strong>', $replace, $phrase);
					//
					//	              ?>
                    <br /><br />

					<?php// If comments are open or we have at least one comment, load up the comment template.



					?>

					<?php endwhile; else: ?>

                        <h3>Sorry, no posts matched your criteria.</h3>

					<?php endif;


					?>

                    <div class="clear"></div>
                </div>

                <div class="col-md-3 col_3_padding_single_left">
                    <div class="tags">
						<?php

						$terms =wp_get_post_tags($post->ID);
						//                   echo '<p>';
						foreach($terms as $term) {

							//                            echo $term->name; //the output
							//                            echo get_tag_link($term->term_id);
							echo '<span class="tagbox"><a class="taglink" href="'. get_tag_link($term->term_id) .'">'. $term->name . '</a></span>' . "\n"   ;
							//                            echo $string .= '<span class="tagbox"><a class="taglink" href="'. get_tag_link($tag->term_id) .'">'. $tag->name . '</a></span>' . "\n"   ;

						}
						//                    echo '</p>';
						//  the_tags('', '' ,'' ); ?>
                    </div>
					<?php
					do_action( 'side_matter_list_notes' );
					?>

                </div>

            </div>


            <div class="col-md-4 sidebar_right">

                <!--//single_left-->

				<?php get_template_part('templates/sidebar', 'single'); ?>

                <div class="clear"></div>
            </div>

			<?php  comments_template(); ?>
        </article>
    </div><!--//content-->


<?php get_sidebar(); ?>

<?php get_footer(); ?>