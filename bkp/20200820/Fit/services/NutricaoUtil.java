package br.com.academia.util;


import org.junit.Test;

/**
 * Classe Utilitária com funções neccessárias
 * utilitárias para calculos nutricionais
 * @author allan-braga
 *
 */
public class NutricaoUtil {

	@Test
	public void teste() {
		/*DecimalFormat df = new DecimalFormat("0.00");
		double dcW7 = calculoDCJacksonPollockWard7DobrasFemin(43, 40, 30, 41, 45, 55, 55, 60);
		double dcJ7 = calculoDCJacksonPollock7DobrasFemin(43, 40, 30, 41, 45, 55, 55, 60);
		
		double dcW3 = calculoDCJacksonPollockWard3DobrasFemin(43,41, 55, 60);
		double dcJ3 = calculoDCJacksonPollock3DobrasFemin(43, 41, 55, 60);
		
		double perc_gordura = percentualGorduraSiriLohman(43,"feminino",dcW7);
		
		System.out.println("J.P. & W 3 Dobras = " +df.format(percentualGorduraSiriLohman(43,"feminino",dcW3)));
		System.out.println("Jackson Pollock 3 Dobras = " + df.format(percentualGorduraSiriLohman(43,"feminino",dcJ3)));
		
		System.out.println("\nJ.P. & W 7 Dobras = " +df.format(percentualGorduraSiriLohman(43,"feminino",dcW7)));
		System.out.println("Jackson Pollock 7 Dobras = " + df.format(percentualGorduraSiriLohman(43,"feminino",dcJ7)));
		
		System.out.println("\nIMC = "+ calculaIMC(0, 0));
		
		System.out.println("Residual = " + calculoMassaResidual("masculino", 75));
		System.out.println("Gorda = " + calculoMassaCorporalGorda(85.5, perc_gordura));
		System.out.println("Magra = " + calculoMassaCorporalMagraKG(85.5, calculoMassaCorporalGorda(85.5, perc_gordura)));
		System.out.println("\nMassa Ossea " + calculoMassaOssea(1.65, 12, 10, 1, 14));
		
		System.out.println("\nFalkner = " + percentualGorduraFalkner(18, 12, 15, 10));
		
		perc_gordura = calculoDurningWomersley40_49_Femin(43, 25, 45, 55);
		System.out.println("Durning e Womersley " + percentualGorduraSiriLohman(43, "feminino", perc_gordura));
		
		double[] vetor = new double[]{100,11,1,40,65,4,6};
		vetor = ordenaVetor(vetor);
		for (double d : vetor) {
			System.out.println(d);
		}
		
		System.out.println("\nOssea = " + calculoMassaOsseaKg(1.66, 0.18,0.35));
		*/
		
		double dc = calculoDCGuedes("masculino", 12, 16, 26, 0, 0, 0);
		System.out.println(percentualGorduraSiri(dc));
		
		System.out.println(calculaGorduraAbsGuedesKg(75.1,20.17));
		
		
	}
	
	public static double[] ordenaVetor(double[] vetor){
		double aux = 0;
		for (int i = 0; i < (vetor.length) -1; i++) {
			for (int j = i; j <(vetor.length) -1; j++) {
				if (vetor[i] > vetor[j + 1]) {
					aux = vetor[i];
					vetor[i] = vetor[j + 1];
					vetor[j +1] = aux;
				}
			}
		}
		return vetor;
	}

	/**
	 * Retorna a média entre 3 valores
	 * @param medida1
	 * @param medida2
	 * @param medida3
	 * @return
	 */
	public static double calculaMedia(double medida1,double medida2,double medida3){
		return (medida1 + medida2 + medida3) / 3;
	}
	
	/**
	 * Retorna o percentual de Gordura Falkner
	 * @param percentGordura
	 * @param percentIdealGodura
	 * @return
	 */
	public static double percentualGorduraSobraFalkner(double percentGordura,
			double percentIdealGodura) {
		return (percentGordura - percentIdealGodura);
	}

	/**
	 * Calcula diferenca percentual de gordura ideal - percentual de gordura
	 * @param gorduraIdeal
	 * @param percentGordura
	 * @return
	 */
	public static double calculaDiferencaPesoIdeal(double gorduraIdeal, double percentGordura){
		return percentGordura - gorduraIdeal;
	}
	
	/**
	 * Retorna em KG a quantidade
	 * @param peso
	 * @param percent_peso_ideal
	 * @return
	 */
	public static double calculaKgPesoIdealSobrePeso(double peso, double diferenca_peso_ideal){
		return diferenca_peso_ideal * peso / 100;
	}
	
	/**
	 * Retorna o percentual ideal de gordura de acordo com a Idade Falkner
	 * @param idade
	 * @return
	 */
	public static double percentualIdealGorduraFalkner(double idade) {
		double resultado = 0;
		if (idade < 30)
			resultado = 0.13 + 0.01;
		else
			resultado = 0.13 + ((idade - 30) * 0.002);
		return resultado * 100;
	}

	/**
	 * Retorna o percentual de gordura livre passando a gordura
	 * @param gordura
	 * @return
	 */
	public static double percentualLivreGorduraFalkner(double gordura) {
		return (100 - gordura);
	}

	/**
	 * Fórmula para predição da Gordura Corporal
	 *	Faulkner (1968)
	 * Avalia o percentual de gordura diretamente
	 * @param triceps
	 * @param subescapular
	 * @param supra_iliacao
	 * @param abdominal
	 * @return
	 */
	public static double percentualGorduraFalkner(double triceps,
			double subescapular, double supra_iliacao, double abdominal) {
		double soma = triceps + subescapular + supra_iliacao + abdominal;
		double resultado = ((soma * 0.153 + 5.783) / 100) * 100;
		return resultado;
	}
	
	/**
	 * Fórmula para predição da Gordura Corporal
	 *	Siri (1961)
	 *	Avalia o percentual de gordura a partir da Densidade Corporal (DC) 
	 * encontrada em outros 	protocolos.
	 * @param densidade_corporal
	 * @return
	 */
	public static double  percentualGorduraSiriLohman(int idade,String sexo,double densidade_corporal){
		switch (sexo) {
		case "masculino":
			if (idade >= 7 && idade <= 8 ) 
				return ((5.38 / densidade_corporal) - 4.97) * 100;
			else if(idade >= 9 && idade <= 10 )
				return ((5.30 / densidade_corporal) - 4.89) * 100;
			else if(idade >= 11 && idade <= 12 )
				return ((5.23 / densidade_corporal) - 4.81) * 100;
			else if(idade >= 13 && idade <= 14 )
				return ((5.07 / densidade_corporal) - 4.64) * 100;
			else if(idade >= 15 && idade <= 16 )
				return ((5.03 / densidade_corporal) - 4.59) * 100;
			else if(idade >= 17&& idade <= 19 )
				return ((4.98 / densidade_corporal) - 4.53) * 100;
			else if(idade >= 20 && idade <= 50 )
				return ((4.95 / densidade_corporal) - 4.50) * 100;
			break;
		case "feminino":
			if (idade >= 7 && idade <= 8 ) 
				return ((5.43 / densidade_corporal) - 5.03) * 100;
			else if(idade >= 9 && idade <= 10 )
				return ((5.35 / densidade_corporal) - 4.95) * 100;
			else if(idade >= 11 && idade <= 12 )
				return ((5.25 / densidade_corporal) - 4.84) * 100;
			else if(idade >= 13 && idade <= 14 )
				return ((5.12 / densidade_corporal) - 4.69) * 100;
			else if(idade >= 15 && idade <= 16 )
				return ((5.07 / densidade_corporal) - 4.64) * 100;
			else if(idade >= 17&& idade <= 19 )
				return ((5.05 / densidade_corporal) - 4.62) * 100;
			else if(idade >= 20 && idade <= 50 )
				return ((5.03 / densidade_corporal) - 4.59) * 100;			
			break;
		}
		return 0;
	}
	
	/**
	 * Fórmula para predição da Gordura Corporal
	 *	Siri (1961)
	 *	Avalia o percentual de gordura a partir da Densidade Corporal (DC) 
	 * encontrada em outros 	protocolos.
	 * @param densidade_corporal
	 * @return
	 */
	public static double  percentualGorduraSiri(double densidade_corporal){
		return ((4.95 / densidade_corporal) -4.5) * 100;
	}
	/**
	 * Metodo que calcula o IMC
	 * @param peso
	 * @param altura
	 * @return
	 */
	public static double calculaIMC(double peso, double altura) {
		double imc;
		imc =   peso / (altura * altura);
		return imc;
	}

	/**
	 * Retorna a descrição do IMC
	 * @param imc
	 * @return
	 */
	public static String resultadoIMC(double imc) {
		String result;
		if (imc <= 17) 
			result = "Muito abaixo do peso";
		else if (imc <= 18.49)
			result = "Abaixo do Peso";
		else if (imc <= 25)
			result = "Peso ideal";
		else if (imc <= 30)
			//result = "Acima do Peso";
			result = "Acima";
		else if (imc <= 35)
			result = "Obesidade l";
		else if (imc <= 40)
			result = "Obesidade ll";
		else 
			result = "Obesidade lll";		
		return result;
	}
	
	/**
	 * Principais Fórmulas para predição  da Densidade Corporal
	 */
	
	/**
	 * Guedes (1994)
	 * Homens : Tríceps, supra-ilíaca e abdome
     * Mulheres: Coxa, supra-ilíaca e subescapular
	 * @return
	 */
	public static double calculoDCGuedes(String genero,double triceps_h,double supra_iliaca_h,double abdominal_h,
			double coxa_m, double supra_iliaca_m, double sub_escapular_m){
		if(genero.equals("masculino"))
			return 1.17136 - 0.06706  * Math.log10(triceps_h + supra_iliaca_h + abdominal_h);
		else if(genero.equals("feminino"))
			return  1.16650- 0.07063 * Math.log10 (coxa_m + supra_iliaca_m + sub_escapular_m);
		return 0;
	}
	
	/**
	 * Jackson & Pollock Masculino 3 Dobras
	 * Equação generalizada de estimativa de densidade corporal para homens, entre 18 e 61 anos
	 * @param idade
	 * @param torax
	 * @param abdominal
	 * @param coxa
	 * @return
	 */
	public static double calculoDCJacksonPollock3DobrasMasc(int idade, double torax,double abdominal,double coxa){
		double soma = torax + abdominal + coxa;
		return (1.109380 - (0.0008267* (soma))) +(0.0000016 * Math.pow((soma), 2)) - (0.0002574 * idade);
	}
	
	/**
	 * Jackson & Pollock Masculino 7 Dobras
	 * Equação generalizada de estimativa de densidade corporal para homens, entre 18 e 61 anos
	 * @param idade
	 * @param torax
	 * @param axilar_media
	 * @param triceps
	 * @param subescapular
	 * @param abdominal
	 * @param supra_iliaca
	 * @param coxa
	 * @return
	 */
	public static double calculoDCJacksonPollock7DobrasMasc(int idade, double torax,double axilar_media,double triceps,double subescapular, 
			double abdominal,double supra_iliaca, double coxa){
		double soma = torax + axilar_media + triceps + subescapular + abdominal + supra_iliaca + coxa;
		return (1.11200000 - (0.00043499 * soma) + (0.00000055 *Math.pow((soma), 2)) - (0.00028826 * idade));
	}

	/**
	 * Jackson & Pollock Feminino 3 Dobras
	 * Equação generalizada de estimativa da densidade corporal para mulheres, entre 18 e 55 anos:
	 * @param idade
	 * @param (tríceps,
	 * @param abdominal
	 * @param coxa
	 * @return
	 */
	public static double calculoDCJacksonPollock3DobrasFemin(int idade, double triceps,double supra_iliaca,double coxa){
		double soma = triceps + supra_iliaca + coxa;
		return (1.0994921 - (0.0009929 * (soma))) +(0.0000023 * Math.pow((soma), 2)) - (0.0001392 * idade);
	}
	
	
	/**
	 * Jackson & Pollock Feminino 7 Dobras
	 * @param idade
	 * @param torax
	 * @param axilar_media
	 * @param triceps
	 * @param subescapular
	 * @param abdominal
	 * @param supra_iliaca
	 * @param coxa
	 * @return
	 */
	public static double calculoDCJacksonPollock7DobrasFemin(int idade, double torax,
			double axilar_media,double triceps,double subescapular, 
			double abdominal,double supra_iliaca, double coxa){
		double soma = torax + axilar_media + triceps + subescapular + abdominal + supra_iliaca + coxa;
		return (1.0970 - (0.00046971 * soma) + (0.00000056 * Math.pow((soma), 2)) - (0.00012828 * idade));
	}
	
	
	
	/**
	 * Jackson & Pollock Feminino 3 Dobras
	 * Equação generalizada de estimativa da densidade corporal para mulheres, entre 18 e 55 anos:
	 * @param idade
	 * @param torax
	 * @param abdominal
	 * @param coxa
	 * @return
	 */
	public static double calculoDCJacksonPollockWard3DobrasFemin(int idade, double triceps,double supra_iliaca,double coxa){
		double soma = triceps + supra_iliaca + coxa;
		return (1.0994921 - (0.0009929 * (soma))) +(0.0000023 * Math.pow((soma), 2)) - (0.0001392 * idade);
	}
	
	
	/**
	 * Jackson, Pollock & Ward Feminino 7 Dobras
	 * @param idade
	 * @param torax
	 * @param axilar_media
	 * @param triceps
	 * @param subescapular
	 * @param abdominal
	 * @param supra_iliaca
	 * @param coxa
	 * @return
	 */
	public static double calculoDCJacksonPollockWard7DobrasFemin(int idade, double torax,
			double axilar_media,double triceps,double subescapular, 
			double abdominal,double supra_iliaca, double coxa){
		double soma = torax + axilar_media + triceps + subescapular + abdominal + supra_iliaca + coxa;
		return (1.0970 - (0.00046971 * soma) + (0.00000056 * Math.pow((soma), 2)) - (0.00012828 * idade));
	}
	
	
	/**
	 * Retorna a Massa Ossea
	 * @param altura
	 * @param biestiloide
	 * @param biecon_umeral
	 * @param biecon_femural
	 * @param bimaleolar
	 * @return
	 */
	public static double calculoMassaOssea(double altura, double biestiloide, double biecon_umeral, double biecon_femural,
			double bimaleolar){
		double soma = (biestiloide + biecon_umeral + biecon_femural + bimaleolar);
		double mo = soma / 4;
		mo = Math.pow(mo, 2);
		return ((mo * (altura * 0.00092)));
	}
	
	public static double calculoMassaOsseaKg(double altura, double punho, double femur){
		double estatura  = Math.pow(altura, 2);
		return (Math.pow((estatura * punho * femur * 400),0.712) * 3.02);
	}
	
	
	/**
	 * Retorna a massa residual 
	 * @param genero
	 * @param peso
	 * @return
	 */
	public static double calculoMassaResidual(String sexo,double peso){
		double mr;
		if(sexo.equals("masculino")){
			mr = peso * 0.241;
			return (mr *100) / peso;
		}else if(sexo.equals("feminino")){
			mr = peso * 0.209;
			return (mr *100) / peso;
		}
		return 0;
	}
	
	/**
	 * Método que retorna a quantidade de Massa Gorda
	 * @param peso
	 * @param percentual_gordura
	 * @return
	 */
	public static double calculoMassaCorporalGorda(double peso, double percentual_gordura){
		return ((peso * percentual_gordura) / 100);
	}
	
	/**
	 * Metodo que retorna a Massa Muscular
	 * @param peso
	 * @param massa_corporal_gorda
	 * @param massa_ossea
	 * @param massa_residual
	 * @return
	 */
	public static double calculoMassaMuscular(double peso,double massa_corporal_gorda,
			double massa_ossea,double massa_residual){
		return (peso - (massa_corporal_gorda + massa_ossea + massa_residual));
	}
	
	/**
	 * Retorna a Massa Corporal Magra em KG
	 * @param peso
	 * @param massa_corporal_gorda
	 * @return
	 */
	public static double calculoMassaCorporalMagraKG(double peso,double massa_corporal_gorda){
		return peso - massa_corporal_gorda;
	}
	
	/**
	 * Retorna a Massa Corporal Magra em %
	 * @param peso
	 * @param massa_corporal_gorda
	 * @return
	 */
	public static double calculoMassaCorporalMagraPercentual(double peso,double massa_corporal_gorda){
		double mcm = peso - massa_corporal_gorda;
		return (mcm * 100) / peso;
	}
	
	
	/**
	 * Retorna a Massa Corporal Ideal
	 * @param massa_corporal_magra_kg
	 * @param percent_gord_desejado
	 * @return
	 */
	public static double calculoMassaCorporalIdeal(double massa_corporal_magra_kg,
			double percent_gord_desejado){
		return (massa_corporal_magra_kg - (1 -(percent_gord_desejado / 100)));
	}
	
	/**
	 * Retorna a Massa Corporal em Excesso
	 * @param peso
	 * @param massa_corporal_ideal
	 * @return
	 */
	public static double calculoMassaCorporalExcesso(double peso,double  massa_corporal_ideal){
		return (peso - massa_corporal_ideal);
	}
	
	
	public static double calculoMCDeurenbergPrePubere(double biceps,double triceps, 
			double supra_escapular,double supra_iliaca){
		double soma = biceps + triceps + supra_escapular + supra_iliaca;
		if (soma > 0) {
			return ((29.85 * Math.log10(soma)) - 25.87);
		}else
			return 0; 	
	}
	
	public static double calculoMCDeurenbergPubere(double biceps,double triceps, 
			double supra_escapular,double supra_iliaca){
		double soma = biceps + triceps + supra_escapular + supra_iliaca;
		if (soma > 0) {
			return ((23.94 * Math.log10(soma)) - 18.89);
		}else
			return 0;
		
	}
	
	public static double calculoMCDeurenbergPosPubere(double biceps,double triceps, 
			double supra_escapular,double supra_iliaca){
		double soma = biceps + triceps + supra_escapular + supra_iliaca;
		if (soma > 0) {
			return ((39.02 * Math.log10(soma)) - 43.49);
		}else
			return 0;
	}
	
	
	public static double calculoDurningWomersley17_19_Masc(double triceps,
			double biceps, double sub_escapular,double supra_iliaca){
		return 1.162 - 0.063 * (Math.log10(triceps + biceps + sub_escapular + supra_iliaca));
	}
	
	public static double calculoDurningWomersley20_29_Masc(double triceps,
			double biceps, double sub_escapular,double supra_iliaca){
		return 1.1631 - 0.0632 * (Math.log10(triceps + biceps + sub_escapular + supra_iliaca));
	}
	
	public static double calculoDurningWomersley30_39_Masc(double triceps,
			double biceps, double sub_escapular,double supra_iliaca){
		return 1.1422 - 0.0544 * (Math.log10(triceps + biceps + sub_escapular + supra_iliaca));
	}
	
	public static double calculoDurningWomersley40_49_Masc(double triceps,
			double biceps, double sub_escapular,double supra_iliaca){
		return 1.162 - 0.07 * (Math.log10(triceps + biceps + sub_escapular + supra_iliaca));
	}
	
	public static double calculoDurningWomersley50_72_Masc(double triceps,
			double biceps, double sub_escapular,double supra_iliaca){
		return 1.1715 - 0.0779 * (Math.log10(triceps + biceps + sub_escapular + supra_iliaca));
	}
	
	public static double calculoDurningWomersley16_19_Femin(double triceps,
			double biceps, double sub_escapular,double supra_iliaca){
		return 1.1549 - 0.0678 * (Math.log10(triceps + biceps + sub_escapular + supra_iliaca));
	}
	
	public static double calculoDurningWomersley20_29_Femin(double triceps,
			double biceps, double sub_escapular,double supra_iliaca){
		return 1.1599 - 0.0717* (Math.log10(triceps + biceps + sub_escapular + supra_iliaca));
	}
	
	public static double calculoDurningWomersley30_39_Femin(double triceps,
			double biceps, double sub_escapular,double supra_iliaca){
		return 1.1423 - 0.0632 * (Math.log10(triceps + biceps + sub_escapular + supra_iliaca));
	}
	
	public static double calculoDurningWomersley40_49_Femin(double triceps,
			double biceps, double sub_escapular,double supra_iliaca){
		return 1.1333 - 0.0612 * (Math.log10(triceps + biceps + sub_escapular + supra_iliaca));
	}
	
	public static double calculoDurningWomersley50_59_Femin(double triceps,
			double biceps, double sub_escapular,double supra_iliaca){
		return 1.1339 - 0.0645 * (Math.log10(triceps + biceps + sub_escapular + supra_iliaca));
	}
	
	
	/**
	 * Método criado para retorna o % Ideal Mínimo e Máximo
	 * @param idade
	 * @param opcaoMinMax
	 * @param sexo
	 * @return
	 */
	public static double gorduraCorporalIdeal(int idade,int opcaoMinMax,int sexo){
		//1 = Minimo, 2 = Maximo
		//1 = Masculino, 2 = Feminino
		if (opcaoMinMax == 1) {
			if (idade  >= 20 && idade <= 29){
				if(sexo == 1)
					return 14;
				return 20;
			}else
			if(idade >= 30 && idade <= 39){
				if(sexo == 1)
					return 15;
				return 21;
			}else
			if(idade >= 40 && idade <= 49){
				if(sexo == 1)
					return 17;
				return 22;
			}else
			if(idade >= 50 && idade <= 59){
				if(sexo == 1)
					return 18;
				return 23;
			}
		}else{
			if (idade  >= 20 && idade <= 29){
				if(sexo == 1)
					return 20;
				return 28;
			}else
			if(idade >= 30 && idade <= 39){
				if(sexo == 1)
					return 21;
				return 29;
			}else
			if(idade >= 40 && idade <= 49){
				if(sexo == 1)
					return 23;
				return 30;
			}else
			if(idade >= 50 && idade <= 59){
				if(sexo == 1)
					return 24;
				return 31;
			}
		}
		return 0;
	}
	
	
	public static double calculaGorduraAbsGuedesKg(double peso_atual,double perc_gordura){
		return peso_atual * (perc_gordura / 100);
	}
	
	public static double calculaMassaMagrasGuedesKg(double peso, double gordura_absoluta){
		return peso - gordura_absoluta;
	}
}
