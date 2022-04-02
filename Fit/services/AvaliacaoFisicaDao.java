package br.com.academia.dao;

import java.io.Serializable;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;

import br.com.academia.factory.ServiceLocator;
import br.com.academia.model.Aluno;
import br.com.academia.model.Anamnese;
import br.com.academia.model.AvaliacaoFisica;
import br.com.academia.model.DesvioPostural;
import br.com.academia.model.Diametro;
import br.com.academia.model.DobraCutanea;
import br.com.academia.model.Perimetro;
import br.com.academia.model.TesteAvaliacao;

public class AvaliacaoFisicaDao  implements Serializable{

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;

	public int inserir(AvaliacaoFisica avaliacaoFisica) {
		StringBuilder sb = new StringBuilder();
		sb.append("INSERT INTO avaliacao_fisica");
		sb.append("(");
		sb.append("dobraCutanea,");
		sb.append("diametro,");
		sb.append("perimetro,");
		sb.append("resultado_gordura_ideal_minimo,");
		sb.append("resultado_gordura_ideal_maximo,");
		sb.append("resultado_gordura_atual,");
		sb.append("resultado_peso_gordo,");
		sb.append("resultado_peso_magro,");
		sb.append("resultado_peso_ideal,");
		sb.append("peso_magro_residual,");
		sb.append("peso_magro_osseo,");
		sb.append("peso_magro_muscular,");
		sb.append("peso_magro_perc_muscular,");
		sb.append("numero_avaliacao,");
		sb.append("idade_atual,");
		sb.append("peso_atual,");
		sb.append("altura,");
		sb.append("data,");
		sb.append("aluno,");
		sb.append("imc,");
		sb.append("resultado_imc,");
		sb.append("protocolo,");
		sb.append("observacao,");
		sb.append("anamnese,");
		sb.append("teste_resistencia,");
		sb.append("desvio_postural,");
		sb.append("resultadoPesoGorduraIdeal,");
		sb.append("resultadoPesoGorduraAtual,");
		sb.append("valorCinturaQuadril,");
		sb.append("resultadoValorCinturaQuadril)");
		sb.append("VALUES");
		sb.append("(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		try (Connection con = ServiceLocator.getConexao();
			PreparedStatement ps = con.prepareStatement(sb.toString(),PreparedStatement.RETURN_GENERATED_KEYS);){
			ps.setDouble(1, avaliacaoFisica.getDobraCutanea().getIddobraCutanea());
			ps.setDouble(2, avaliacaoFisica.getDiametro().getIddiametro());
			ps.setDouble(3, avaliacaoFisica.getPerimetro().getIdperimetro());
			ps.setDouble(4, avaliacaoFisica.getResultado_gordura_ideal_minimo());
			ps.setDouble(5, avaliacaoFisica.getResultado_gordura_ideal_maximo());
			ps.setDouble(6, avaliacaoFisica.getResultado_gordura_atual());
			ps.setDouble(7, avaliacaoFisica.getResultado_peso_gordo());
			ps.setDouble(8, avaliacaoFisica.getResultado_peso_magro());
			ps.setDouble(9, avaliacaoFisica.getResultado_peso_ideal());
			ps.setDouble(10, avaliacaoFisica.getPeso_magro_residual());
			ps.setDouble(11, avaliacaoFisica.getPeso_magro_osseo());
			ps.setDouble(12, avaliacaoFisica.getPeso_magro_muscular());
			ps.setDouble(13, avaliacaoFisica.getPeso_magro_perc_muscular());
			ps.setInt(14, avaliacaoFisica.getNumero_avaliacao());
			ps.setInt(15, avaliacaoFisica.getIdade_atual());
			ps.setDouble(16,avaliacaoFisica.getPeso_atual());
			ps.setDouble(17, avaliacaoFisica.getAltura());
			ps.setDate(18, new java.sql.Date(avaliacaoFisica.getData().getTime()));
			ps.setInt(19,  avaliacaoFisica.getAluno().getIdAluno());
			ps.setDouble(20, avaliacaoFisica.getImc());
			ps.setString(21, avaliacaoFisica.getResultado_imc());
			ps.setString(22, avaliacaoFisica.getProtocolo());
			ps.setString(23, avaliacaoFisica.getObservacao());
			ps.setInt(24, avaliacaoFisica.getAnamnese().getIdanamnese());
			ps.setInt(25, avaliacaoFisica.getTesteAvaliacao().getId());
			ps.setInt(26, avaliacaoFisica.getDesvioPostural().getId());
			ps.setDouble(27, avaliacaoFisica.getResultadoPesoGorduraIdeal());
			ps.setDouble(28, avaliacaoFisica.getResultadoPesoGorduraAtual());
			ps.setDouble(29, avaliacaoFisica.getValorCinturaQuadril());
			ps.setString(30, avaliacaoFisica.getResultadoValorCinturaQuadril());
			
			ps.executeUpdate();

			try(ResultSet rs = ps.getGeneratedKeys();){
				if (rs.next()) {
					return  rs.getInt(1);
				}	
			}catch(Exception e){
				e.printStackTrace();
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		return 0;
	}

	public void editar(AvaliacaoFisica avaliacaoFisica) {
		StringBuilder sb = new StringBuilder();
		sb.append(" UPDATE avaliacao_fisica SET ");
		sb.append("dobraCutanea		     	 	 	= ?,");
		sb.append("diametro 		 	 	    	= ?,");
		sb.append("perimetro 						= ?,");
		sb.append("resultado_gordura_ideal_minimo 	= ?,");
		sb.append("resultado_gordura_ideal_maximo  	= ?,");
		sb.append("resultado_gordura_atual 			= ?,");
		sb.append("resultado_peso_gordo 			= ?,");
		sb.append("resultado_peso_magro				= ?,");
		sb.append("resultado_peso_ideal 			= ?,");
		sb.append("peso_magro_residual 				= ?,");
		sb.append("peso_magro_osseo 			 	= ?,");
		sb.append("peso_magro_muscular 				= ?,");
		sb.append("peso_magro_perc_muscular 		= ?,");
		sb.append("numero_avaliacao 				= ?,");
		sb.append("idade_atual 						= ?,");
		sb.append("peso_atual 						= ?,");
		sb.append("altura 							= ?,");
		sb.append("data 							= ?,");
		sb.append("aluno 							= ?,");
		sb.append("imc 								= ?,");
		sb.append("resultado_imc					= ?,");
		sb.append("protocolo      					= ?,");
		sb.append("observacao     					= ?,");
		sb.append("anamnese     					= ?,");
		sb.append("teste_resistencia				= ?,");
		sb.append("desvio_postural					= ?,");
		
		sb.append("resultadoPesoGorduraIdeal		= ?,");
		sb.append("resultadoPesoGorduraAtual		= ?,");
		sb.append("valorCinturaQuadril				= ?,");
		sb.append("resultadoValorCinturaQuadril		= ?");
		
		sb.append(" WHERE idavaliacao_fisica 		= ?");


		
		try (Connection conexao = ServiceLocator.getConexao();
			 PreparedStatement ps = conexao.prepareStatement(sb.toString());){
			ps.setDouble(1, avaliacaoFisica.getDobraCutanea().getIddobraCutanea());
			ps.setDouble(2, avaliacaoFisica.getDiametro().getIddiametro());
			ps.setDouble(3, avaliacaoFisica.getPerimetro().getIdperimetro());
			ps.setDouble(4, avaliacaoFisica.getResultado_gordura_ideal_minimo());
			ps.setDouble(5, avaliacaoFisica.getResultado_gordura_ideal_maximo());
			ps.setDouble(6, avaliacaoFisica.getResultado_gordura_atual());
			ps.setDouble(7, avaliacaoFisica.getResultado_peso_gordo());
			ps.setDouble(8, avaliacaoFisica.getResultado_peso_magro());
			ps.setDouble(9, avaliacaoFisica.getResultado_peso_ideal());
			ps.setDouble(10, avaliacaoFisica.getPeso_magro_residual());
			ps.setDouble(11, avaliacaoFisica.getPeso_magro_osseo());
			ps.setDouble(12, avaliacaoFisica.getPeso_magro_muscular());
			ps.setDouble(13, avaliacaoFisica.getPeso_magro_perc_muscular());
			ps.setInt(14, avaliacaoFisica.getNumero_avaliacao());
			ps.setInt(15, avaliacaoFisica.getIdade_atual());
			ps.setDouble(16,avaliacaoFisica.getPeso_atual());
			ps.setDouble(17, avaliacaoFisica.getAltura());
			ps.setDate(18, new java.sql.Date(avaliacaoFisica.getData().getTime()));
			ps.setInt(19,avaliacaoFisica.getAluno().getIdAluno());
			ps.setDouble(20, avaliacaoFisica.getImc());
			ps.setString(21, avaliacaoFisica.getResultado_imc());
			ps.setString(22, avaliacaoFisica.getProtocolo());
			ps.setString(23, avaliacaoFisica.getObservacao());
			ps.setInt(24, avaliacaoFisica.getAnamnese().getIdanamnese());
			ps.setInt(25, avaliacaoFisica.getTesteAvaliacao().getId());
			ps.setInt(26, avaliacaoFisica.getDesvioPostural().getId());
			
			ps.setDouble(27, avaliacaoFisica.getResultadoPesoGorduraIdeal());
			ps.setDouble(28, avaliacaoFisica.getResultadoPesoGorduraAtual());
			ps.setDouble(29, avaliacaoFisica.getValorCinturaQuadril());
			ps.setString(30, avaliacaoFisica.getResultadoValorCinturaQuadril());
			
			ps.setInt(31, avaliacaoFisica.getIdavaliacao_fisica());
			ps.executeUpdate();
		} catch (Exception e) {
			e.printStackTrace();
		}

	}

	public ArrayList<AvaliacaoFisica> consultar(String parametro) {
		
		ArrayList<AvaliacaoFisica> lista = new ArrayList<AvaliacaoFisica>();
		
		try (Connection conexao = ServiceLocator.getConexao();
			 PreparedStatement ps = conexao.prepareStatement(parametro);
			 ResultSet rs = ps.executeQuery();){
			
			while (rs.next()) {
				Diametro diametro = new Diametro();
				diametro.setIddiametro(rs.getInt("diametro.iddiametro"));
				diametro.setBiestiloide(rs.getDouble("diametro.biestiloide"));
				diametro.setBimaleolar(rs.getDouble("diametro.bimaleolar"));
				diametro.setBiepicondilo_umeral(rs.getDouble("diametro.biepicondilo_umeral"));
				diametro.setBiepicondilo_femeral(rs.getDouble("diametro.biepicondilo_femeral"));
				diametro.setBiacromial(rs.getDouble("diametro.biacromial"));
				diametro.setTorax_antero_posterior(rs.getDouble("diametro.torax_antero_posterior"));
				diametro.setTorax_transverso(rs.getDouble("diametro.torax_transverso"));
				diametro.setCrista_iliaca(rs.getDouble("diametro.crista_iliaca"));
				diametro.setBitrocanterica(rs.getDouble("diametro.bitrocanterica"));
				
				DobraCutanea dobraCutanea = new DobraCutanea();
				dobraCutanea.setIddobraCutanea(rs.getInt("dobra_cutanea.iddobra_cutanea"));
				dobraCutanea.setTriceps1(rs.getDouble("dobra_cutanea.triceps1"));
				dobraCutanea.setTriceps2(rs.getDouble("dobra_cutanea.triceps2"));
				dobraCutanea.setTriceps3(rs.getDouble("dobra_cutanea.triceps3"));
				dobraCutanea.setTriceps_media(rs.getDouble("dobra_cutanea.triceps_media"));
				dobraCutanea.setSubescapular1(rs.getDouble("dobra_cutanea.subescapular1"));
				dobraCutanea.setSubescapular2(rs.getDouble("dobra_cutanea.subescapular2"));
				dobraCutanea.setSubescapular3(rs.getDouble("dobra_cutanea.subescapular3"));
				dobraCutanea.setSubescapular_media(rs.getDouble("dobra_cutanea.subescapular_media"));
				dobraCutanea.setAbdominal1(rs.getDouble("dobra_cutanea.abdominal1"));
				dobraCutanea.setAbdominal2(rs.getDouble("dobra_cutanea.abdominal2"));
				dobraCutanea.setAbdominal3(rs.getDouble("dobra_cutanea.abdominal3"));
				dobraCutanea.setAbdominal_media(rs.getDouble("dobra_cutanea.abdominal_media"));
				dobraCutanea.setCoxa_medial1(rs.getDouble("dobra_cutanea.coxa_medial1"));
				dobraCutanea.setCoxa_medial2(rs.getDouble("dobra_cutanea.coxa_medial2"));
				dobraCutanea.setCoxa_medial3(rs.getDouble("dobra_cutanea.coxa_medial3"));
				dobraCutanea.setCoxa_medial_media(rs.getDouble("dobra_cutanea.coxa_medial_media"));
				dobraCutanea.setPantu_medial1(rs.getDouble("dobra_cutanea.pantu_medial1"));
				dobraCutanea.setPantu_medial2(rs.getDouble("dobra_cutanea.pantu_medial2"));
				dobraCutanea.setPantu_medial3(rs.getDouble("dobra_cutanea.pantu_medial3"));
				dobraCutanea.setPantu_medial_media(rs.getDouble("dobra_cutanea.pantu_medial_media"));
				dobraCutanea.setTorax1(rs.getDouble("dobra_cutanea.torax1"));
				dobraCutanea.setTorax2(rs.getDouble("dobra_cutanea.torax2"));
				dobraCutanea.setTorax3(rs.getDouble("dobra_cutanea.torax3"));
				dobraCutanea.setTorax_media(rs.getDouble("dobra_cutanea.torax_media"));
				dobraCutanea.setBiceps1(rs.getDouble("dobra_cutanea.biceps1"));
				dobraCutanea.setBiceps2(rs.getDouble("dobra_cutanea.biceps2"));
				dobraCutanea.setBiceps3(rs.getDouble("dobra_cutanea.biceps3"));
				dobraCutanea.setBiceps_media(rs.getDouble("dobra_cutanea.biceps_media"));
				dobraCutanea.setAxiliar_media1(rs.getDouble("dobra_cutanea.axiliar_media1"));
				dobraCutanea.setAxiliar_media2(rs.getDouble("dobra_cutanea.axiliar_media2"));
				dobraCutanea.setAxiliar_media3(rs.getDouble("dobra_cutanea.axiliar_media3"));
				dobraCutanea.setAxiliar_media_media(rs.getDouble("dobra_cutanea.axiliar_media_media"));
				dobraCutanea.setSupra_iliaca1(rs.getDouble("dobra_cutanea.supra_iliaca1"));
				dobraCutanea.setSupra_iliaca2(rs.getDouble("dobra_cutanea.supra_iliaca2"));
				dobraCutanea.setSupra_iliaca3(rs.getDouble("dobra_cutanea.supra_iliaca3"));
				dobraCutanea.setSupra_iliaca_media(rs.getDouble("supra_iliaca_media"));
				dobraCutanea.setSupra_espinal1(rs.getDouble("dobra_cutanea.supra_espinal1"));
				dobraCutanea.setSupra_espinal2(rs.getDouble("dobra_cutanea.supra_espinal2"));
				dobraCutanea.setSupra_espinal3(rs.getDouble("dobra_cutanea.supra_espinal3"));
				dobraCutanea.setSupra_espinal_media(rs.getDouble("dobra_cutanea.supra_espinal_media"));
				
				Perimetro perimetro = new Perimetro();
				perimetro.setIdperimetro(rs.getInt("perimetro.idperimetro"));
				perimetro.setPescoco(rs.getDouble("perimetro.pescoco"));
				perimetro.setTorax(rs.getDouble("perimetro.torax"));
				perimetro.setAbdominal(rs.getDouble("perimetro.abdominal"));
				perimetro.setCintura(rs.getDouble("perimetro.cintura"));
				perimetro.setBraco_direito_relaxado(rs.getDouble("perimetro.braco_direito_relaxado"));
				perimetro.setBraco_esquerdo_relaxado(rs.getDouble("perimetro.braco_esquerdo_relaxado"));
				perimetro.setBraco_direito_contraido(rs.getDouble("perimetro.braco_direito_contraido"));
				perimetro.setBraco_esquerdo_contraido(rs.getDouble("perimetro.braco_esquerdo_contraido"));
				perimetro.setCoxa_direita(rs.getDouble("perimetro.coxa_direita"));
				perimetro.setCoxa_esquerda(rs.getDouble("perimetro.coxa_esquerda"));
				perimetro.setPerna_direita(rs.getDouble("perimetro.perna_direita"));
				perimetro.setPerna_esquerda(rs.getDouble("perimetro.perna_esquerda"));
				perimetro.setOmbro(rs.getDouble("perimetro.ombro"));
				perimetro.setQuadril(rs.getDouble("perimetro.quadril"));
				perimetro.setAntebraco_direito(rs.getDouble("perimetro.antebraco_direito"));
				perimetro.setAntebraco_esquerdo(rs.getDouble("perimetro.antebraco_esquerdo"));
				
				
				Anamnese anamnese = new Anamnese();
				anamnese.setIdanamnese(rs.getInt("anamnese.idanamnese"));
				anamnese.setMeta(rs.getString("anamnese.meta"));
				anamnese.setPraticaExercicios(rs.getBoolean("anamnese.praticaExercicios"));
				anamnese.setPraticaExercicios_frequencia(rs.getInt("anamnese.praticaExercicios_frequencia"));
				anamnese.setHabitoFumar(rs.getBoolean("anamnese.habitoFumar"));
				anamnese.setHabitoFumar_tempo(rs.getString("anamnese.habitoFumar_tempo"));
				anamnese.setHabitoFumar_qtDia(rs.getInt("anamnese.habitoFumar_qtd_dia"));
				anamnese.setRestricoesAtividades(rs.getString("anamnese.restricoesAtividades"));
				anamnese.setUtilizaMedicamentos(rs.getString("anamnese.utilizaMedicamento"));
				anamnese.setSenteDores(rs.getString("anamnese.senteDores"));
				anamnese.setSofreuAcidente(rs.getString("anamnese.sofreuAcidente"));
				anamnese.setEstaemDieta(rs.getString("anamnese.estaemDieta"));
				anamnese.setPossuiAlergia(rs.getString("anamnese.possuiAlergia"));
				anamnese.setObservacoes(rs.getString("anamnese.observacoes"));

				
				Aluno aluno = new Aluno();
				aluno.setIdAluno(rs.getInt("aluno.idaluno"));
				aluno.setNome(rs.getString("aluno.nome"));
				aluno.setGenero(rs.getString("aluno.genero"));
				aluno.setData_nascimento(rs.getDate("aluno.data_nascimento"));
				
				TesteAvaliacao testeAvaliacao = new TesteAvaliacao();
				testeAvaliacao.setId(rs.getInt("teste_resistencia.id"));
				testeAvaliacao.setSentarAlcancar(rs.getInt("teste_resistencia.teste_sentar_alcancar"));
				testeAvaliacao.setTesteFlexaoBraco(rs.getInt("teste_flexao_braco"));
				testeAvaliacao.setTesteAbdominal(rs.getInt("teste_resistencia.teste_abdominal"));
				
				DesvioPostural desvioPostural = new DesvioPostural();
				desvioPostural.setId(rs.getInt("desvio.id"));
				desvioPostural.setPescoco_dorsal(rs.getString("desvio.pescoco_dorsal"));
				desvioPostural.setPescoco_dorsal_obs(rs.getString("desvio.pescoco_dorsal_obs"));
				desvioPostural.setOmbro_dorsal(rs.getString("desvio.ombro_dorsal"));
				desvioPostural.setOmbro_dorsal_obs(rs.getString("desvio.ombro_dorsal_obs"));
				desvioPostural.setColuna_dorsal(rs.getString("desvio.coluna_dorsal"));
				desvioPostural.setQuadril_dorsal(rs.getString("desvio.quadril_dorsal"));
				desvioPostural.setQuadril_dorsal_obs(rs.getString("desvio.quadril_dorsal_obs"));
				desvioPostural.setJoelho_dorsal(rs.getString("desvio.joelho_dorsal"));
				desvioPostural.setJoelho_dorsal_obs(rs.getString("desvio.joelho_dorsal_obs"));
				desvioPostural.setCalcanhar_dorsal(rs.getString("desvio.calcanhar_dorsal"));
				desvioPostural.setCalcanhar_dorsal_obs(rs.getString("desvio.calcanhar_dorsal_obs"));
				desvioPostural.setPe_dorsal(rs.getString("desvio.pe_dorsal"));
				desvioPostural.setPe_dorsal_obs(rs.getString("desvio.pe_dorsal_obs"));
				desvioPostural.setPescoco_lateral(rs.getString("desvio.pescoco_lateral"));
				desvioPostural.setPescoco_lateral_obs(rs.getString("desvio.pescoco_lateral_obs"));
				desvioPostural.setPeitoral_lateral(rs.getString("desvio.peitoral_lateral"));
				desvioPostural.setPeitoral_lateral_obs(rs.getString("desvio.peitoral_lateral_obs"));
				desvioPostural.setOmbro_escapula_lateral(rs.getString("desvio.ombro_escapula_lateral"));
				desvioPostural.setOmbro_escapula_lateral_obs(rs.getString("desvio.ombro_escapula_lateral_obs"));
				desvioPostural.setCifose_lateral(rs.getString("desvio.cifose_lateral"));
				desvioPostural.setCifose_lateral_obs(rs.getString("desvio.cifose_lateral_obs"));
				desvioPostural.setLordose_lateral(rs.getString("desvio.lordose_lateral"));
				desvioPostural.setLordose_lateral_obs(rs.getString("desvio.lordose_lateral_obs"));
				desvioPostural.setTronco_lateral(rs.getString("desvio.tronco_lateral"));
				desvioPostural.setTronco_lateral_obs(rs.getString("desvio.tronco_lateral_obs"));
				desvioPostural.setAbdome_lateral(rs.getString("desvio.abdome_lateral"));
				desvioPostural.setAbdome_lateral_obs(rs.getString("desvio.abdome_lateral_obs"));
				desvioPostural.setJoelho_lateral(rs.getString("desvio.joelho_lateral"));
				desvioPostural.setJoelho_lateral_obs(rs.getString("desvio.joelho_lateral_obs"));
				desvioPostural.setImagepath_1(rs.getString("desvio.imagepath_1"));
				desvioPostural.setImagepath_2(rs.getString("desvio.imagepath_2"));
				desvioPostural.setImagepath_3(rs.getString("desvio.imagepath_3"));
				
				AvaliacaoFisica avaliacaoFisica = new AvaliacaoFisica();
				avaliacaoFisica.setIdavaliacao_fisica(rs.getInt("avaliacao.idavaliacao_fisica"));
				avaliacaoFisica.setAluno(aluno);
				avaliacaoFisica.setDobraCutanea(dobraCutanea);
				avaliacaoFisica.setDiametro(diametro);
				avaliacaoFisica.setPerimetro(perimetro);
				avaliacaoFisica.setResultado_gordura_ideal_minimo(rs.getDouble("avaliacao.resultado_gordura_ideal_minimo"));
				avaliacaoFisica.setResultado_gordura_ideal_maximo(rs.getDouble("avaliacao.resultado_gordura_ideal_maximo"));
				avaliacaoFisica.setResultado_gordura_atual(rs.getDouble("avaliacao.resultado_gordura_atual"));
				avaliacaoFisica.setResultado_peso_gordo(rs.getDouble("avaliacao.resultado_peso_gordo"));
				avaliacaoFisica.setResultado_peso_magro(rs.getDouble("avaliacao.resultado_peso_magro"));
				avaliacaoFisica.setResultado_peso_ideal(rs.getDouble("avaliacao.resultado_peso_ideal"));
				avaliacaoFisica.setPeso_magro_residual(rs.getDouble("avaliacao.peso_magro_residual"));
				avaliacaoFisica.setPeso_magro_osseo(rs.getDouble("avaliacao.peso_magro_osseo"));
				avaliacaoFisica.setPeso_magro_muscular(rs.getDouble("avaliacao.peso_magro_muscular"));
				avaliacaoFisica.setPeso_magro_perc_muscular(rs.getDouble("avaliacao.peso_magro_perc_muscular"));
				avaliacaoFisica.setNumero_avaliacao(rs.getInt("avaliacao.numero_avaliacao"));
				avaliacaoFisica.setIdade_atual(rs.getInt("avaliacao.idade_atual"));
				avaliacaoFisica.setPeso_atual(rs.getDouble("avaliacao.peso_atual"));
				avaliacaoFisica.setAltura(rs.getDouble("avaliacao.altura"));
				avaliacaoFisica.setData(rs.getDate("avaliacao.data"));
				avaliacaoFisica.setImc(rs.getDouble("avaliacao.imc"));
				avaliacaoFisica.setResultado_imc(rs.getString("avaliacao.resultado_imc"));
				avaliacaoFisica.setProtocolo(rs.getString("avaliacao.protocolo"));
				avaliacaoFisica.setObservacao(rs.getString("observacao"));
				avaliacaoFisica.setResultadoPesoGorduraAtual(rs.getDouble("avaliacao.resultadoPesoGorduraAtual"));
				avaliacaoFisica.setResultadoPesoGorduraIdeal(rs.getDouble("avaliacao.resultadoPesoGorduraIdeal"));
				avaliacaoFisica.setValorCinturaQuadril(rs.getDouble("avaliacao.valorCinturaQuadril"));
				avaliacaoFisica.setResultadoValorCinturaQuadril(rs.getString("avaliacao.resultadoValorCinturaQuadril"));
				avaliacaoFisica.setAnamnese(anamnese);
				avaliacaoFisica.setTesteAvaliacao(testeAvaliacao);
				avaliacaoFisica.setDesvioPostural(desvioPostural);
				
				lista.add(avaliacaoFisica);
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		return lista;
	}

	public void excluir(int id) throws Exception {
		String sql = null;
		sql = "DELETE FROM avaliacao_fisica WHERE ";
		sql = sql + "idavaliacao_fisica = " + id;
		try (Connection con = ServiceLocator.getConexao();
			 PreparedStatement comando = con.prepareStatement(sql);){
			 comando.executeUpdate();
		} catch (SQLException ex) {
			ex.printStackTrace();
		}
	}
}
