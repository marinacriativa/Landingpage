
<?php $__env->startSection('title', 'produtos'); ?>
<?php $__env->startSection('content'); ?>
<main class="main">
				<section class="promo-primary promo-primary--shop">
					<picture>
						<source srcset="/public/static/images/banner/papagaio.jpg" media="(min-width: 992px)"/><img class="img--bg" src="/public/static/images/banner/papagaio.jpg" alt="img"/>
					</picture>
					<div class="promo-primary__description"> <span><?php echo e(ucfirst($translations["frontoffice"]["join_banner_description"])); ?></span></div>
					<div class="container">
						<div class="row">
							<div class="col-auto">
								<div class="align-container">
									<div class="align-container__item"><span class="promo-primary__pre-title"> <?php echo e(ucfirst($translations["frontoffice"]["join_banner_pre_title"])); ?></span>
										<h1 class="promo-primary__title"><span><?php echo e(ucfirst($translations["frontoffice"]["join_banner_title_1"])); ?> </span> <span><?php echo e(ucfirst($translations["frontoffice"]["join_banner_title_2"])); ?></span></h1>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>	
				<section class="section background--brown">
						<div class="container">
							<div class="row align-items-end margin-bottom">
								<div class="col-lg-12">
									<div class="heading heading--primary txtform"><span class="heading__pre-title"><?php echo e(ucfirst($translations["frontoffice"]["join_pre_title"])); ?></span>
										<h2 class="heading__title"><span><?php echo e(ucfirst($translations["frontoffice"]["join_title"])); ?></span></h2>
										<div>
											<p><strong><?php echo e(ucfirst($translations["frontoffice"]["join_sub_title"])); ?></strong></p>
										<p>
											<?php echo e(ucfirst($translations["frontoffice"]["join_text_1"])); ?> <br>
											<?php echo e(ucfirst($translations["frontoffice"]["join_text_2"])); ?> <br>
											<?php echo e(ucfirst($translations["frontoffice"]["join_text_3"])); ?>

										</p>
										</div>
									</div>
								</div>
							</div>
						</div>
				</section>
						<div class="contacts-wrapper">
							<div class="container">
								<div class="row justify-content-end memberrow">
									<div class="col-xl-10">
										<div class="form__fieldset">
											<form class="form message-form" action="javascript:void(0);">
												<h6 class="form__title"><?php echo e(ucfirst($translations["frontoffice"]["join_form_title"])); ?></h6><span class="form__text"><?php echo e(ucfirst($translations["frontoffice"]["join_form_text"])); ?></span>
												<div class="row">
													<div class="col-lg-4">
														<label class="label_vol" for="first-name"><?php echo e(ucfirst($translations["frontoffice"]["join_message_fill_name"])); ?></label>
														<input class="form__field" type="text" name="first-name"  required="required"/>
													</div>
													<div class="col-lg-4">
														<label class="label_vol" for="last-name"><?php echo e(ucfirst($translations["frontoffice"]["join_message_fill_lastname"])); ?></label>
														<input class="form__field" type="text" name="last-name"  required="required"/>
													</div>
													<div class="col-lg-4">
														<label class="label_vol" for="email"><?php echo e(ucfirst($translations["frontoffice"]["join_message_fill_email"])); ?></label>
														<input class="form__field" type="email" name="email"  required="required"/>
													</div>
													<div class="col-lg-4">
														<label class="label_vol" for="tel"><?php echo e(ucfirst($translations["frontoffice"]["join_message_fill_phone"])); ?></label>
														<input class="form__field" type="tel" name="phone-number" />
													</div>
													<div class="col-lg-4">
														<label class="label_vol" for="date"><?php echo e(ucfirst($translations["frontoffice"]["join_message_fill_date"])); ?></label>
														<input class="form__field date_color" type="date" id="data" name="data" >
													</div>
													<div class="col-lg-4">
														<label class="label_vol" for="adress"><?php echo e(ucfirst($translations["frontoffice"]["join_message_fill_address"])); ?></label>
														<input class="form__field" type="text" name="address" />
													</div>
													<div class="col-lg-4">
														<label class="label_vol" for="country"><?php echo e(ucfirst($translations["frontoffice"]["join_message_fill_country"])); ?></label>
														<select class="form__select" name="country-select">
															<option value=""><?php echo e(ucfirst($translations["frontoffice"]["join_message_fill_country"])); ?></option>
															<option value="Afghanistan">Afghanistan</option>
															<option value="Åland Islands">Åland Islands</option>
															<option value="Albania">Albania</option>
															<option value="Algeria">Algeria</option>
															<option value="American Samoa">American Samoa</option>
															<option value="Andorra">Andorra</option>
															<option value="Angola">Angola</option>
															<option value="Anguilla">Anguilla</option>
															<option value="Antarctica">Antarctica</option>
															<option value="Antigua and Barbuda">Antigua and Barbuda</option>
															<option value="Argentina">Argentina</option>
															<option value="Armenia">Armenia</option>
															<option value="Aruba">Aruba</option>
															<option value="Australia">Australia</option>
															<option value="Austria">Austria</option>
															<option value="Azerbaijan">Azerbaijan</option>
															<option value="Bahamas">Bahamas</option>
															<option value="Bahrain">Bahrain</option>
															<option value="Bangladesh">Bangladesh</option>
															<option value="Barbados">Barbados</option>
															<option value="Belarus">Belarus</option>
															<option value="Belgium">Belgium</option>
															<option value="Belize">Belize</option>
															<option value="Benin">Benin</option>
															<option value="Bermuda">Bermuda</option>
															<option value="Bhutan">Bhutan</option>
															<option value="Bolivia">Bolivia</option>
															<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
															<option value="Botswana">Botswana</option>
															<option value="Bouvet Island">Bouvet Island</option>
															<option value="Brazil">Brazil</option>
															<option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
															<option value="Brunei Darussalam">Brunei Darussalam</option>
															<option value="Bulgaria">Bulgaria</option>
															<option value="Burkina Faso">Burkina Faso</option>
															<option value="Burundi">Burundi</option>
															<option value="Cambodia">Cambodia</option>
															<option value="Cameroon">Cameroon</option>
															<option value="Canada">Canada</option>
															<option value="Cape Verde">Cape Verde</option>
															<option value="Cayman Islands">Cayman Islands</option>
															<option value="Central African Republic">Central African Republic</option>
															<option value="Chad">Chad</option>
															<option value="Chile">Chile</option>
															<option value="China">China</option>
															<option value="Christmas Island">Christmas Island</option>
															<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
															<option value="Colombia">Colombia</option>
															<option value="Comoros">Comoros</option>
															<option value="Congo">Congo</option>
															<option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
															<option value="Cook Islands">Cook Islands</option>
															<option value="Costa Rica">Costa Rica</option>
															<option value="Cote D'ivoire">Cote D'ivoire</option>
															<option value="Croatia">Croatia</option>
															<option value="Cuba">Cuba</option>
															<option value="Cyprus">Cyprus</option>
															<option value="Czech Republic">Czech Republic</option>
															<option value="Denmark">Denmark</option>
															<option value="Djibouti">Djibouti</option>
															<option value="Dominica">Dominica</option>
															<option value="Dominican Republic">Dominican Republic</option>
															<option value="Ecuador">Ecuador</option>
															<option value="Egypt">Egypt</option>
															<option value="El Salvador">El Salvador</option>
															<option value="Equatorial Guinea">Equatorial Guinea</option>
															<option value="Eritrea">Eritrea</option>
															<option value="Estonia">Estonia</option>
															<option value="Ethiopia">Ethiopia</option>
															<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
															<option value="Faroe Islands">Faroe Islands</option>
															<option value="Fiji">Fiji</option>
															<option value="Finland">Finland</option>
															<option value="France">France</option>
															<option value="French Guiana">French Guiana</option>
															<option value="French Polynesia">French Polynesia</option>
															<option value="French Southern Territories">French Southern Territories</option>
															<option value="Gabon">Gabon</option>
															<option value="Gambia">Gambia</option>
															<option value="Georgia">Georgia</option>
															<option value="Germany">Germany</option>
															<option value="Ghana">Ghana</option>
															<option value="Gibraltar">Gibraltar</option>
															<option value="Greece">Greece</option>
															<option value="Greenland">Greenland</option>
															<option value="Grenada">Grenada</option>
															<option value="Guadeloupe">Guadeloupe</option>
															<option value="Guam">Guam</option>
															<option value="Guatemala">Guatemala</option>
															<option value="Guernsey">Guernsey</option>
															<option value="Guinea">Guinea</option>
															<option value="Guinea-bissau">Guinea-bissau</option>
															<option value="Guyana">Guyana</option>
															<option value="Haiti">Haiti</option>
															<option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
															<option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
															<option value="Honduras">Honduras</option>
															<option value="Hong Kong">Hong Kong</option>
															<option value="Hungary">Hungary</option>
															<option value="Iceland">Iceland</option>
															<option value="India">India</option>
															<option value="Indonesia">Indonesia</option>
															<option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
															<option value="Iraq">Iraq</option>
															<option value="Ireland">Ireland</option>
															<option value="Isle of Man">Isle of Man</option>
															<option value="Israel">Israel</option>
															<option value="Italy">Italy</option>
															<option value="Jamaica">Jamaica</option>
															<option value="Japan">Japan</option>
															<option value="Jersey">Jersey</option>
															<option value="Jordan">Jordan</option>
															<option value="Kazakhstan">Kazakhstan</option>
															<option value="Kenya">Kenya</option>
															<option value="Kiribati">Kiribati</option>
															<option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
															<option value="Korea, Republic of">Korea, Republic of</option>
															<option value="Kuwait">Kuwait</option>
															<option value="Kyrgyzstan">Kyrgyzstan</option>
															<option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
															<option value="Latvia">Latvia</option>
															<option value="Lebanon">Lebanon</option>
															<option value="Lesotho">Lesotho</option>
															<option value="Liberia">Liberia</option>
															<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
															<option value="Liechtenstein">Liechtenstein</option>
															<option value="Lithuania">Lithuania</option>
															<option value="Luxembourg">Luxembourg</option>
															<option value="Macao">Macao</option>
															<option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
															<option value="Madagascar">Madagascar</option>
															<option value="Malawi">Malawi</option>
															<option value="Malaysia">Malaysia</option>
															<option value="Maldives">Maldives</option>
															<option value="Mali">Mali</option>
															<option value="Malta">Malta</option>
															<option value="Marshall Islands">Marshall Islands</option>
															<option value="Martinique">Martinique</option>
															<option value="Mauritania">Mauritania</option>
															<option value="Mauritius">Mauritius</option>
															<option value="Mayotte">Mayotte</option>
															<option value="Mexico">Mexico</option>
															<option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
															<option value="Moldova, Republic of">Moldova, Republic of</option>
															<option value="Monaco">Monaco</option>
															<option value="Mongolia">Mongolia</option>
															<option value="Montenegro">Montenegro</option>
															<option value="Montserrat">Montserrat</option>
															<option value="Morocco">Morocco</option>
															<option value="Mozambique">Mozambique</option>
															<option value="Myanmar">Myanmar</option>
															<option value="Namibia">Namibia</option>
															<option value="Nauru">Nauru</option>
															<option value="Nepal">Nepal</option>
															<option value="Netherlands">Netherlands</option>
															<option value="Netherlands Antilles">Netherlands Antilles</option>
															<option value="New Caledonia">New Caledonia</option>
															<option value="New Zealand">New Zealand</option>
															<option value="Nicaragua">Nicaragua</option>
															<option value="Niger">Niger</option>
															<option value="Nigeria">Nigeria</option>
															<option value="Niue">Niue</option>
															<option value="Norfolk Island">Norfolk Island</option>
															<option value="Northern Mariana Islands">Northern Mariana Islands</option>
															<option value="Norway">Norway</option>
															<option value="Oman">Oman</option>
															<option value="Pakistan">Pakistan</option>
															<option value="Palau">Palau</option>
															<option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
															<option value="Panama">Panama</option>
															<option value="Papua New Guinea">Papua New Guinea</option>
															<option value="Paraguay">Paraguay</option>
															<option value="Peru">Peru</option>
															<option value="Philippines">Philippines</option>
															<option value="Pitcairn">Pitcairn</option>
															<option value="Poland">Poland</option>
															<option value="Portugal">Portugal</option>
															<option value="Puerto Rico">Puerto Rico</option>
															<option value="Qatar">Qatar</option>
															<option value="Reunion">Reunion</option>
															<option value="Romania">Romania</option>
															<option value="Russian Federation">Russian Federation</option>
															<option value="Rwanda">Rwanda</option>
															<option value="Saint Helena">Saint Helena</option>
															<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
															<option value="Saint Lucia">Saint Lucia</option>
															<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
															<option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
															<option value="Samoa">Samoa</option>
															<option value="San Marino">San Marino</option>
															<option value="Sao Tome and Principe">Sao Tome and Principe</option>
															<option value="Saudi Arabia">Saudi Arabia</option>
															<option value="Senegal">Senegal</option>
															<option value="Serbia">Serbia</option>
															<option value="Seychelles">Seychelles</option>
															<option value="Sierra Leone">Sierra Leone</option>
															<option value="Singapore">Singapore</option>
															<option value="Slovakia">Slovakia</option>
															<option value="Slovenia">Slovenia</option>
															<option value="Solomon Islands">Solomon Islands</option>
															<option value="Somalia">Somalia</option>
															<option value="South Africa">South Africa</option>
															<option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
															<option value="Spain">Spain</option>
															<option value="Sri Lanka">Sri Lanka</option>
															<option value="Sudan">Sudan</option>
															<option value="Suriname">Suriname</option>
															<option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
															<option value="Swaziland">Swaziland</option>
															<option value="Sweden">Sweden</option>
															<option value="Switzerland">Switzerland</option>
															<option value="Syrian Arab Republic">Syrian Arab Republic</option>
															<option value="Taiwan">Taiwan</option>
															<option value="Tajikistan">Tajikistan</option>
															<option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
															<option value="Thailand">Thailand</option>
															<option value="Timor-leste">Timor-leste</option>
															<option value="Togo">Togo</option>
															<option value="Tokelau">Tokelau</option>
															<option value="Tonga">Tonga</option>
															<option value="Trinidad and Tobago">Trinidad and Tobago</option>
															<option value="Tunisia">Tunisia</option>
															<option value="Turkey">Turkey</option>
															<option value="Turkmenistan">Turkmenistan</option>
															<option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
															<option value="Tuvalu">Tuvalu</option>
															<option value="Uganda">Uganda</option>
															<option value="Ukraine">Ukraine</option>
															<option value="United Arab Emirates">United Arab Emirates</option>
															<option value="United Kingdom">United Kingdom</option>
															<option value="United States">United States</option>
															<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
															<option value="Uruguay">Uruguay</option>
															<option value="Uzbekistan">Uzbekistan</option>
															<option value="Vanuatu">Vanuatu</option>
															<option value="Venezuela">Venezuela</option>
															<option value="Viet Nam">Viet Nam</option>
															<option value="Virgin Islands, British">Virgin Islands, British</option>
															<option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
															<option value="Wallis and Futuna">Wallis and Futuna</option>
															<option value="Western Sahara">Western Sahara</option>
															<option value="Yemen">Yemen</option>
															<option value="Zambia">Zambia</option>
															<option value="Zimbabwe">Zimbabwe</option>
														</select>
													</div>
													<div class="col-lg-4">
														<label class="label_vol" for="city"><?php echo e(ucfirst($translations["frontoffice"]["join_message_fill_city"])); ?></label>
														<input class="form__field" type="text" name="city" />
													</div>
													<div class="col-lg-4">
														<label class="label_vol" for="zip"><?php echo e(ucfirst($translations["frontoffice"]["join_message_fill_zip"])); ?></label>
														<input class="form__field" type="text" name="zip" />
													</div>
												</div>
											</form>
										
											<form class="form message-form" action="javascript:void(0);">
												<h6 class="form__title"><?php echo e(ucfirst($translations["frontoffice"]["join_help_title"])); ?></h6>
											</form>				
											<div class="accordion accordion--primary nohover">
												<div class="accordion__title-block accordion__close accor">
													<label>
														<input type="checkbox" value=""> <h6 class="accordion__title accordion__close accor"><?php echo e(ucfirst($translations["frontoffice"]["join_member_title"])); ?></h6>
													</label>
												</div>
												<div class="accordion__text-block">
													<div class="checkb vol_int">
														<p><strong class="title_vol"><?php echo e(ucfirst($translations["frontoffice"]["join_membership_title"])); ?></strong></p>
														<button type="button" id="btn1" class="activeBtn2" onclick="btnFunc1()"><p class="alignleft"><?php echo e(ucfirst($translations["frontoffice"]["join_membership_month_text"])); ?></p><p class="alignright">€5.00</p></button>
														<button type="button" id="btn2" class="deactiveBtn2 btnDeactivated2" onclick="btnFunc2()"><p class="alignleft"><?php echo e(ucfirst($translations["frontoffice"]["join_membership_year_text"])); ?></p><p class="alignright">€45.00</p></button>
													</div>
	
													<form class="form message-form" action="javascript:void(0);">
															<p><strong class="title_vol"><?php echo e(ucfirst($translations["frontoffice"]["join_member_question_1"])); ?></strong></p>
															<label class="form__radio-label"><?php echo e(ucfirst($translations["frontoffice"]["join_member_answer_1"])); ?>

																<input class="form__input-radio" type="radio" name="method-select"  checked="checked"/><span class="form__radio-mask form__radio-mask"></span>
															</label>
															<label class="form__radio-label"><?php echo e(ucfirst($translations["frontoffice"]["join_member_answer_2"])); ?>

																<input class="form__input-radio" type="radio" name="method-select" /><span class="form__radio-mask form__radio-mask"></span>
															</label>
													</form>		
	
													<form class="form message-form" action="javascript:void(0);">
													<p><strong class="title_vol"><?php echo e(ucfirst($translations["frontoffice"]["join_member_question_2"])); ?></strong></p>
													<label class="form__radio-label"><?php echo e(ucfirst($translations["frontoffice"]["join_member_answer_3"])); ?>

														<input class="form__input-radio" type="radio" name="method-select"  checked="checked"/><span class="form__radio-mask form__radio-mask"></span>
													</label>
													<label class="form__radio-label"><?php echo e(ucfirst($translations["frontoffice"]["join_member_answer_4"])); ?>

														<input class="form__input-radio" type="radio" name="method-select" /><span class="form__radio-mask form__radio-mask"></span>
													</label>
													</form>		
	
													<div class="checkb">
														<form class="vol_int">
														<p><strong class="title_vol"><?php echo e(ucfirst($translations["frontoffice"]["join_member_question_3"])); ?></strong></p>
													  	<label class="checkbox-inline">
														<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_member_checkbox_1"])); ?>

													  	</label>
													  	<label class="checkbox-inline">
														<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_member_checkbox_2"])); ?>

													  	</label>
													  	<label class="checkbox-inline">
														<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_member_checkbox_3"])); ?>

													  	</label>
													  	<label class="checkbox-inline">
														<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_member_checkbox_4"])); ?>

													  	</label>
														</form>
													</div>
	
													<div class="col-lg-7 membercol">
														<form class="form message-form" action="javascript:void(0);">
														<p><strong class="title_vol"><?php echo e(ucfirst($translations["frontoffice"]["join_member_question_4"])); ?></strong></p>
														<select class="form__select" name="country-select">
															<option value=""><?php echo e(ucfirst($translations["frontoffice"]["join_member_option"])); ?></option>
															<option value="value2"><?php echo e(ucfirst($translations["frontoffice"]["join_member_option_1"])); ?></option>
															<option value="value3"><?php echo e(ucfirst($translations["frontoffice"]["join_member_option_2"])); ?></option>
															<option value="value4"><?php echo e(ucfirst($translations["frontoffice"]["join_member_option_3"])); ?></option>
															<option value="value5"><?php echo e(ucfirst($translations["frontoffice"]["join_member_option_4"])); ?></option>
														</select>
														</form>
													</div>
	
													<div class="col-lg-7 membercol">
														<form class="form message-form" action="javascript:void(0);">
														<p><strong class="title_vol"><?php echo e(ucfirst($translations["frontoffice"]["join_member_question_5"])); ?></strong></p>
														<textarea class="form__message form__field" name="message" placeholder=<?php echo e(ucfirst($translations["frontoffice"]["join_member_placeholder_message"])); ?>></textarea>
														</form>
													</div>

													</div>
												</div>


											<div class="accordion accordion--primary nohover">
												<div class="accordion__title-block accordion__close accor">
													<label >
														<input type="checkbox" value=""> <h6 class="accordion__title accordion__close accor"><?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_title"])); ?></h6> 
													</label>
												</div>
												<div class="accordion__text-block">
													<form class="form message-form" action="javascript:void(0);">
																<p><strong class="title_vol"><?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_question_1"])); ?></strong></p>
																<label class="form__radio-label"><?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_answer_1"])); ?>

																	<input class="form__input-radio" type="radio" name="method-select"  checked="checked"/><span class="form__radio-mask form__radio-mask"></span>
																</label>
																<label class="form__radio-label"><?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_answer_2"])); ?>

																	<input class="form__input-radio" type="radio" name="method-select" /><span class="form__radio-mask form__radio-mask"></span>
																</label>
													</form>
													<div class="checkb">
														<form class="vol_int">
															<p><strong class="title_vol"><?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_question_2"])); ?></strong></p>
														  <label class="checkbox-inline">
															<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_checkbox_1"])); ?>

														  </label>
														  <label class="checkbox-inline">
															<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_checkbox_2"])); ?>

														  </label>
														  <label class="checkbox-inline">
															<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_checkbox_3"])); ?>

														  </label>
														  <label class="checkbox-inline">
															<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_checkbox_4"])); ?>

														  </label>
														  <label class="checkbox-inline">
															<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_checkbox_5"])); ?>

														  </label>
														</form>
													</div>		
													<div class="checkb">
														<form class="vol_int">
															<p><strong class="title_vol"><?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_question_3"])); ?></strong></p>
														  <label class="checkbox-inline">
															<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_monday"])); ?>

														  </label>
														  <label class="checkbox-inline">
															<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_tuesday"])); ?>

														  </label>
														  <label class="checkbox-inline">
															<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_wednesday"])); ?>

														  </label>
														  <label class="checkbox-inline">
															<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_thursday"])); ?>

														  </label>
														  <label class="checkbox-inline">
															<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_friday"])); ?>

														  </label>
														  <label class="checkbox-inline">
															<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_saturday"])); ?>

														  </label>
														  <label class="checkbox-inline">
															<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_sunday"])); ?>

														  </label>
														</form>
														<div class="vol_int">
															<div class="to">
																<label class="time" for="appt"><?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_from"])); ?></label>
																<input type="time" value="09:00" id="appt" name="appt" >
															</div>
															<div class="from">
																<label class="time" for="appt"><?php echo e(ucfirst($translations["frontoffice"]["join_volunteer_to"])); ?></label>
																<input type="time" value="19:00" id="appt" n>
															</div>
														</div>
													</div>
												</div>
											</div>

											
											<div class="accordion accordion--primary nohover">
													<div class="accordion__title-block accordion__close accor">
														<label>
															<input type="checkbox" value=""> <h6 class="accordion__title accordion__close accor"><?php echo e(ucfirst($translations["frontoffice"]["join_partner_title"])); ?></h6>
														</label>
													</div>
												<div class="accordion__text-block">
													<form class="form message-form" action="javascript:void(0);">
														<h6 class="form__title"><?php echo e(ucfirst($translations["frontoffice"]["join_partner_form_title"])); ?></h6><span class="form__text"><?php echo e(ucfirst($translations["frontoffice"]["join_partner_form_text"])); ?></span>
														<div class="row">
															<div class="col-lg-4">
																<label class="label_vol" for="company"><?php echo e(ucfirst($translations["frontoffice"]["join_partner_message_fill_company"])); ?></label>
																<input class="form__field" type="text" name="company"  required="required"/>
															</div>
															<div class="col-lg-4">
																<label class="label_vol" for="emp-number"><?php echo e(ucfirst($translations["frontoffice"]["join_partner_message_fill_employee"])); ?></label>
																<input class="form__field" type="number" name="emp-number"  required="required"/>
															</div>
															<div class="col-lg-4">
																<label class="label_vol" for="comp-url"><?php echo e(ucfirst($translations["frontoffice"]["join_partner_message_fill_company_web"])); ?></label>
																<input class="form__field" type="text" name="comp-url"  required="required"/>
															</div>
														</div>
													</form>
													<div class="checkb">
														<form class="vol_int">
															<p><strong class="title_vol"><?php echo e(ucfirst($translations["frontoffice"]["join_partner_question_1"])); ?></strong></p>
														  <label class="checkbox-inline">
															<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_partner_checkbox_1"])); ?>

														  </label>
														  <label class="checkbox-inline">
															<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_partner_checkbox_2"])); ?>

														  </label>
														  <label class="checkbox-inline">
															<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_partner_checkbox_3"])); ?>

														  </label>
														  <label class="checkbox-inline">
															<input type="checkbox" value=""> <?php echo e(ucfirst($translations["frontoffice"]["join_partner_checkbox_4"])); ?>

														  </label>
														</form>
													</div>	
													<div class="col-lg-6 membercol">
														<form class="form message-form" action="javascript:void(0);">
														<p><strong class="title_vol"><?php echo e(ucfirst($translations["frontoffice"]["join_partner_question_2"])); ?></strong></p>
														<textarea class="form__message form__field" name="message" placeholder=<?php echo e(ucfirst($translations["frontoffice"]["join_partner_placeholder_message"])); ?>></textarea>
														</form>
													</div>
												</div>
											</div>
											<button class="form__submit" type="submit"><?php echo e(ucfirst($translations["frontoffice"]["join_form_send_btn"])); ?></button>
										</div>
									</div>
								</div>
							</div>
						</div>
					
				<section class="bottom-background background--brown">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<div class="bottom-background__img"><img src="/public/static/images/bottom-bg.png" alt="img"/></div>
							</div>
						</div>
					</div>
				</section>
			</main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/member.blade.php ENDPATH**/ ?>