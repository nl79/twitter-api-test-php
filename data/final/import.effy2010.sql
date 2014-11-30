

LOAD DATA LOCAL INFILE 'effy2010.csv'
INTO TABLE enrollment_data
FIELDS TERMINATED BY ','
    ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(UNITID,EFFYLEV,LSTUDY,XEYNRALM,EFYNRALM,XEYNRALW,EFYNRALW,XFYRAC03,FYRACE03,XFYRAC04,FYRACE04,XFYRAC05,FYRACE05,XFYRAC06,FYRACE06,XFYRAC07,FYRACE07,XFYRAC08,FYRACE08,XFYRAC09,FYRACE09,XFYRAC10,FYRACE10,XFYRAC11,FYRACE11,XFYRAC12,FYRACE12,XEYUNKNM,EFYUNKNM,XEYUNKNW,EFYUNKNW,XEYTOTLM,EFYTOTLM,XEYTOTLW,EFYTOTLW,XEYNRALT,EFYNRALT,XFYRAC18,FYRACE18,XFYRAC19,FYRACE19,XFYRAC20,FYRACE20,XFYRAC21,FYRACE21,XFYRAC22,FYRACE22,XEYUNKNT,EFYUNKNT,XEYTOTLT,EFYTOTLT,XEFYHISM,EFYHISPM,XEFYHISW,EFYHISPW,XEFYAIAM,EFYAIANM,XEFYAIAW,EFYAIANW,XEFYASIM,EFYASIAM,XEFYASIW,EFYASIAW,XEFYBKAM,EFYBKAAM,XEFYBKAW,EFYBKAAW,XEFYNHPM,EFYNHPIM,XEFYNHPW,EFYNHPIW,XEFYWHIM,EFYWHITM,XEFYWHIW,EFYWHITW,XEFY2MOM,EFY2MORM,XEFY2MOW,EFY2MORW,XEFYHIST,EFYHISPT,XEFYAIAT,EFYAIANT,XEFYASIT,EFYASIAT,XEFYBKAT,EFYBKAAT,XEFYNHPT,EFYNHPIT,XEFYWHIT,EFYWHITT,XEFY2MOT,EFY2MORT,XDVEYAIT,DVEYAIT,XDVEYAIM,DVEYAIM,XDVEYAIW,DVEYAIW,XDVEYAPT,DVEYAPT,XDVEYAPM,DVEYAPM,XDVEYAPW,DVEYAPW,XDVEYBKT,DVEYBKT,XDVEYBKM,DVEYBKM,XDVEYBKW,DVEYBKW,XDVEYHST,DVEYHST,XDVEYHSM,DVEYHSM,XDVEYHSW,DVEYHSW,XDVEYWHT,DVEYWHT,XDVEYWHM,DVEYWHM,XDVEYWHW,DVEYWHW) 