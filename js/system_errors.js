

var SYSTEM_ERRORS = {
	//GENERIC ERRORS
	"-1" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> There is no logged user, please login.",
		"class" : "generic"
	},
	"-2" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Error removing record, please try again.",
		"class" : "generic"
	},
	"-3" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> File must be in csv format!",
		"class" : "generic"
	},
	"-4" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> File already processed!",
		"class" : "generic"
	},
	"-5" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Could not move file to final directory!",
		"class" : "generic"
	},
	"-6" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Submission type not allowed.",
		"class" : "generic"
	},
	"-7" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Service reported error(s).",
		"class" : "generic"
	},
	"-8" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Access denied. You don't have permissions to access this operation.",
		"class" : "generic"
	},
	"11" : {
		"type_error" : "success",
		"msg" : "<strong>Holy guacamole!</strong> Record removed.",
		"class" : "generic"
	},
	"12" : {
		"type_error" : "success",
		"msg" : "<strong>Holy guacamole!</strong> Csv(s) processed with success.",
		"class" : "generic"
	},
	"13" : {
		"type_error" : "warning",
		"msg" : "<strong>Attention:</strong> Csv processed.",
		"class" : "generic"
	},
	//SITE ERRORS
	"101" : {
		"type_error" : "success",
		"msg" : "<strong>Holy guacamole!</strong> Site inserted/udpated.",
		"class" : "site"
	},
	"102" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Missing parameters to this Site.",
		"class" : "site"
	},
	"103" : {
		"type_error" : "warning",
		"msg" : "<strong>Attention - </strong> Nothing done to this Site, please try again.",
		"class" : "site"
	},
	//SEASON ERRORS
	"201" : {
		"type_error" : "success",
		"msg" : "<strong>Holy guacamole!</strong> Season inserted/udpated.",
		"class" : "season"
	},
	"202" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Missing parameters to this Site.",
		"class" : "season"
	},
	"203" : {
		"type_error" : "warning",
		"msg" : "<strong>Attention - </strong> Nothing done to this Season, please try again.",
		"class" : "season"
	},
	//CAMPAIGN ERRORS
	"301" : {
		"type_error" : "success",
		"msg" : "<strong>Holy guacamole!</strong> Campaign inserted/udpated.",
		"class" : "campaign"
	},
	"302" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Missing parameters to this Campaign.",
		"class" : "campaign"
	},
	"303" : {
		"type_error" : "warning",
		"msg" : "<strong>Attention - </strong> Nothing done to this Campaign, please try again.",
		"class" : "campaign"
	},
	//PLOT ERRORS
	"401" : {
		"type_error" : "success",	
		"msg" : "<strong>Holy guacamole!</strong> Plot inserted/udpated.",
		"class" : "plot"
	},
	"402" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Missing parameters to this Plot.",
		"class" : "plot"
	},
	"403" : {
		"type_error" : "warning",
		"msg" : "<strong>Attention - </strong> Nothing done to this Plot, please try again.",
		"class" : "plot"
	},
	"405" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Wrong csv structure to this Plot CSV insertion. Maybe you submitted the wrong file.",
		"class" : "plot"
	},
	//SPECIES ERRORS
	"501" : {
		"type_error" : "success",
		"msg" : "<strong>Holy guacamole!</strong> Species inserted/udpated.",
		"class" : "species"
	},
	"502" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Missing parameters to this Species.",
		"class" : "species"
	},
	"503" : {
		"type_error" : "warning",
		"msg" : "<strong>Attention - </strong> Nothing done to this Species, please try again.",
		"class" : "species"
	},
	"504" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Wrong csv structure to this Species CSV insertion. Maybe you submitted the wrong file.",
		"class" : "species"
	},
	//INDIVIDUAL ERRORS
	"601" : {
		"type_error" : "success",
		"msg" : "<strong>Holy guacamole!</strong> Individual inserted/udpated.",
		"class" : "individual"
	},
	"602" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Missing parameters to this Individual.",
		"class" : "individual"
	},
	"603" : {
		"type_error" : "warning",
		"msg" : "<strong>Attention - </strong> Nothing done to this Individual, please try again.",
		"class" : "individual"
	},
	"604" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Wrong csv structure to this Individual CSV insertion. Maybe you submitted the wrong file.",
		"class" : "individual"
	},
	//USERS ERRORS
	"701" : {
		"type_error" : "success",
		"msg" : "<strong>Holy guacamole!</strong> User inserted/udpated.",
		"class" : "users"
	},
	"702" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Missing parameters to this Individual.",
		"class" : "users"
	},
	"703" : {
		"type_error" : "warning",
		"msg" : "<strong>Attention - </strong> Nothing done to this User, please try again.",
		"class" : "users"
	},
	"704" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> There is already a User registered with this email.",
		"class" : "users"
	},
	"705" : {
		"type_error" : "danger",
		"msg" : "<strong>Ups daisy!</strong> Invalid Login. Please, try again.",
		"class" : "users"
	},
	//STRUCTURE ERRORS
	"801" : {
		"type_error" : "success",
		"msg" : "<strong>Holy guacamole!</strong> Individual Structure inserted/udpated.",
		"class" : "structure"
	},
	"802" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Missing parameters to this Individual Structure.",
		"class" : "structure"
	},
	"803" : {
		"type_error" : "warning",
		"msg" : "<strong>Attention - </strong> Nothing done to this Individual Structure, please try again.",
		"class" : "structure"
	},
	"804" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Wrong csv structure to this Individual Structure CSV insertion. Maybe you submitted the wrong file.",
		"class" : "structure"
	},
	//ECOFISIO ERRORS
	"901" : {
		"type_error" : "success",
		"msg" : "<strong>Holy guacamole!</strong> Individual Eco-Physiology sample inserted/udpated.",
		"class" : "ecofisio"
	},
	"902" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Missing parameters to this Individual Eco-Physiology sample.",
		"class" : "ecofisio"
	},
	"903" : {
		"type_error" : "warning",
		"msg" : "<strong>Attention - </strong> Nothing done to this Individual Eco-Physiology sample, please try again.",
		"class" : "ecofisio"
	},
	//UNISPEC REFLECTANCE ERRORS
	"1001" : {
		"type_error" : "success",
		"msg" : "<strong>Holy guacamole!</strong> Unispec Reflectance index inserted/udpated and related Eco-Physiology indices updated.",
		"class" : "reflectante"
	},
	"1002" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Missing parameters to this Unispec Reflectance index.",
		"class" : "reflectante"
	},
	"1003" : {
		"type_error" : "warning",
		"msg" : "<strong>Attention - </strong> Nothing done to this Unispec Reflectance index, please try again.",
		"class" : "reflectante"
	},
	"1004" : {
		"type_error" : "warning",
		"msg" : "<strong>Attention - </strong> Unispec Reflectance index inserted/udpated but Eco-Physiology indices were not updated. Please try again.",
		"class" : "reflectante"
	},
	"1005" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> There are no Eco-Physiology sample for this Individual, on the selected campaign!",
		"class" : "reflectante"
	},
	"1006" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Invalid Individual code. Please check Individual existance.",
		"class" : "reflectante"
	},
	//PLOT SAMPLE ERRORS
	"1011" : {
		"type_error" : "success",
		"msg" : "<strong>Holy guacamole!</strong> Plot Water Info inserted/udpated.",
		"class" : "plotattribute"
	},
	"1012" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Missing parameters to this Plot Water Info.",
		"class" : "plotattribute"
	},
	"1013" : {
		"type_error" : "warning",
		"msg" : "<strong>Attention - </strong> Nothing done to this Plot sample, please try again.",
		"class" : "plotattribute"
	},
	"1014" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Missing parameters to this Plot Water Info CSV update.",
		"class" : "plotattribute"
	},
	"1015" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong>  Wrong csv structure to this Plot Water Info CSV update. Maybe you submitted the wrong file.",
		"class" : "plotattribute"
	},
	"1016" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Invalid Campaign selection to this Plot Water Info CSV update.",
		"class" : "plotattribute"
	},
	//SOIL SAMPLE ERRORS
	"1021" : {
		"type_error" : "success",
		"msg" : "<strong>Holy guacamole!</strong> Soil sample inserted/udpated.",
		"class" : "plotsoil"
	},
	"1022" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Missing parameters to this Soil sample.",
		"class" : "plotsoil"
	},
	"1023" : {
		"type_error" : "warning",
		"msg" : "<strong>Attention - </strong> Nothing done to this Soil sample, please try again.",
		"class" : "plotsoil"
	},
	"1024" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Missing parameters to this Plot Soil Info CSV update.",
		"class" : "plotattribute"
	},
	"1025" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Invalid Campaign selection to this Plot Soil Info CSV update.",
		"class" : "plotattribute"
	},
	"1026" : {
		"type_error" : "danger",
		"msg" : "<strong>Attention - </strong> Wrong csv structure to this Plot Soil Info CSV update. Maybe you submitted the wrong file.",
		"class" : "plotattribute"
	}
}