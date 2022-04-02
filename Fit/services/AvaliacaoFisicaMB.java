package br.com.academia.view;

import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.Serializable;
import java.net.URLEncoder;
import java.nio.file.Files;
import java.nio.file.Path;
import java.text.DecimalFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import javax.annotation.PostConstruct;
import javax.faces.FacesException;
import javax.faces.bean.ManagedBean;
import javax.faces.bean.ViewScoped;

import org.omnifaces.util.Ajax;
import org.omnifaces.util.Faces;
import org.primefaces.context.RequestContext;
import org.primefaces.event.FileUploadEvent;
import org.primefaces.model.chart.Axis;
import org.primefaces.model.chart.AxisType;
import org.primefaces.model.chart.BarChartModel;
import org.primefaces.model.chart.ChartSeries;

import br.com.academia.dao.AlunoDao;
import br.com.academia.dao.AnamneseDao;
import br.com.academia.dao.AvaliacaoFisicaDao;
import br.com.academia.dao.BioimpedanciaDao;
import br.com.academia.dao.DesvioPosturalDao;
import br.com.academia.dao.DiametroDao;
import br.com.academia.dao.DobraCutaneaDao;
import br.com.academia.dao.PerimetroDao;
import br.com.academia.dao.TesteAvaliacaoDao;
import br.com.academia.model.Academia;
import br.com.academia.model.Aluno;
import br.com.academia.model.AvaliacaoFisica;
import br.com.academia.model.Bioimpedancia;
import br.com.academia.util.Constantes;
import br.com.academia.util.JSFUtil;
import br.com.academia.util.NutricaoUtil;
import br.com.academia.util.SessionContext;
import br.com.academia.util.UtilPath;

/**
 * 
 * @author allan-braga
 *
 */
@ManagedBean(name = "AvaliacaoFisicaBean")
@ViewScoped
public class AvaliacaoFisicaMB implements Serializable{

	/**
	 * 
	 */
	
	
	private static final long serialVersionUID = 1L;

	private AvaliacaoFisica avaliacaoFisica;
	private AvaliacaoFisica auxAvaliacaoFisica;
	private Aluno aluno;
	private Academia academia;
	private boolean btnNovoVisibility;
	
	private Date filtroDe;
	private Date filtroAte;
	
	private AlunoDao alunoDao;
	private DobraCutaneaDao dobraCutaneaDAO;
	private DiametroDao diametroDAO;
	private PerimetroDao perimetroDAO;
	private AvaliacaoFisicaDao avaliacaoFisicaDAO;
	private AnamneseDao anamneseDAO;
	private TesteAvaliacaoDao testeAvaliacaoDao;
	private DesvioPosturalDao desvioPosturalDao;
	
	private ArrayList<Aluno> alunos;
	private ArrayList<Aluno> alunosFilter;
	private ArrayList<AvaliacaoFisica> avaliacoesFisicas;
	private ArrayList<AvaliacaoFisica> avaliacoesFisicasFilter;
	public int optionReport;
	
	//Linhas para destaque de seleção de calculo
	private boolean linha1,linha2,linha3,linha4,linha5,linha6,linha7,linha8,linha9,linha10;
	private String fotoFrente, fotoLado, fotoCostas;
	
    private BarChartModel barModel;
	private byte[] data;
	
	private String sql;
	private String imagesPathAvaliacao;
	
	// Alisson Fernando Berçalini
	private Bioimpedancia bioimpedancia;
	private BioimpedanciaDao bioimpedanciaDao;
	private Bioimpedancia bioimpedanciaAux;
	private String parametro;
	//private List<Bioimpedancia> bioimpedancias;
	private List<Bioimpedancia> bios;
	private String nomeAluno;
	private Boolean botaoNovoAluno;
	private Boolean renderizarCampo = true;
	private Boolean quantidadeAvaliacao = true;
	
	@PostConstruct
	public void init() {
		SessionContext sessionContext = SessionContext.getInstace();
		
		// Alisson Fernando Berçalini
		setBotaoNovoAluno(false);
		bioimpedancia = new Bioimpedancia();
		this.bioimpedanciaDao = new BioimpedanciaDao();
		this.bioimpedanciaAux = new Bioimpedancia();
		
		testeAvaliacaoDao = new TesteAvaliacaoDao();
		dobraCutaneaDAO = new DobraCutaneaDao();
		diametroDAO = new DiametroDao();
		perimetroDAO = new PerimetroDao();
		avaliacaoFisicaDAO = new AvaliacaoFisicaDao();
		anamneseDAO = new AnamneseDao();
		alunoDao = new AlunoDao();
		desvioPosturalDao = new DesvioPosturalDao();
		
		avaliacaoFisica = new AvaliacaoFisica();
		auxAvaliacaoFisica = new AvaliacaoFisica();
		aluno = new Aluno();
		btnNovoVisibility = true;
		
		if (sessionContext.getAttribute("academia") != null) {
			academia = (Academia) sessionContext.getAttribute("academia");
			alunos = alunoDao.listarAlunoPAcademia(academia.getIdAcademia());
		}
		
		
		this.parametro = "SELECT * FROM bioimpedancia as bio INNER JOIN aluno as alu "
				+ "ON bio.aluno = alu.idaluno "
				+ "WHERE alu.academia = " + academia.getIdAcademia();
		
		//listaBioimpedancia();
		settarListaBiopedanciaAluno();
		
		createBarModel();
		imagesPathAvaliacao = Constantes.URL_IMG_ALUNOS_AVALIACAO + academia.getIdAcademia() + "/";
		
		sql = "SELECT * FROM avaliacao_fisica  AS avaliacao INNER JOIN aluno as aluno "
				  + "ON (avaliacao.aluno = aluno.idAluno) INNER JOIN diametro as diametro "
				  + "ON (avaliacao.diametro = diametro.iddiametro) INNER JOIN perimetro as perimetro "
				  + "ON (avaliacao.perimetro = perimetro.idperimetro) INNER JOIN dobra_cutanea as dobra_cutanea "
				  + "ON (avaliacao.dobraCutanea = dobra_cutanea.iddobra_cutanea) INNER JOIN anamnese as anamnese "
				  + "ON (avaliacao.anamnese = anamnese.idanamnese) LEFT OUTER JOIN teste_resistencia AS teste_resistencia "
				  + "ON (avaliacao.teste_resistencia = teste_resistencia.id) LEFT OUTER JOIN desvio_postural as desvio "
				  + "ON (avaliacao.desvio_postural = desvio.id) "
				  + "WHERE avaliacao.aluno = ";
	}

	
	public void filtrarPorNome() {
		if(nomeAluno.equals("Selecione...")) {
		} else {
		String sql = "SELECT * FROM bioimpedancia as bio INNER JOIN aluno AS alu"
				+ " ON bio.aluno = alu.idAluno"
				+ " WHERE alu.academia = " + academia.getIdAcademia() + " AND"
						+ " alu.nome = '" + nomeAluno + "'";
		System.out.println(sql);
		this.bios = bioimpedanciaDao.listar(sql);
	}
}		
	
	public String salvarBioimpedancia() {
		
	/*	if(bioimpedancia.getValorRelacaoCinturaQuadril()) {
			this.bioimpedancia.setValorRelacaoCinturaQuadril(this.bioimpedancia.getCintura() / this.bioimpedancia.getQuadril());	
		} */
		
		if(bioimpedancia.getQuadril() == 0.00) {
			this.bioimpedancia.setValorRelacaoCinturaQuadril(0.00);
		}
		
		
			
		bioimpedancia.getAluno().setIdAluno(aluno.getIdAluno());
		bioimpedancia.getAvaliacaoFisica().setIdavaliacao_fisica(auxAvaliacaoFisica.getIdavaliacao_fisica());
		if(bioimpedancia.getId() == null) {
			bioimpedancia.setDataInicio(new Date(System.currentTimeMillis()));
			bioimpedanciaDao.salvar(bioimpedancia);
			
			JSFUtil.addMensagensSucesso("Bioimpedância salva com sucesso");
			bios = new ArrayList<>();
			settarListaBiopedanciaAluno();
			this.bioimpedancia = new Bioimpedancia();
			return "/pages/avaliacao/bioimpedancia.xhtml?faces-redirect=true";
		} else {
			System.out.println("Sem ser null");
			this.bioimpedancia = new Bioimpedancia();
			return "";
		}
	}
	
	public String excluirBioimpedancia(Bioimpedancia bio) {
		bioimpedanciaDao.excluir(bio);
		JSFUtil.addMensagensSucesso("Excluido com sucesso");
		settarListaBiopedanciaAluno();
		Ajax.update("frmAvaliacao:tabView:tblAvaliacoes");
		return "/pages/avaliacao/bioimpedancia.xhtml?faces-redirect=true";
	}
	
	public void createBarModel() {
        barModel = calculaGraficoDesvioPostural();
         
        barModel.setTitle("Resultado da Avaliação Postural");
        barModel.setLegendPosition("ne");
        
        Axis yAxis = barModel.getAxis(AxisType.Y);
        yAxis.setMin(0);
        yAxis.setMax(120);
        
        Axis xAxis = barModel.getAxis(AxisType.X);
        xAxis.setLabel("Referência");
    }
	
	public void salvarAvaliacao(){
		
		if(auxAvaliacaoFisica.getProtocolo() == null) {
			JSFUtil.addMensagensErro("Escolha um protocolo");
			return;
		}
		
		if(!quantidadeAvaliacao) {
			System.out.println("Entrou na avaliação");
			AvaliacaoFisica tmpAvaliacaoFisica = this.avaliacoesFisicas.get(this.avaliacoesFisicas.size() - 1);
			this.auxAvaliacaoFisica.setNumero_avaliacao(tmpAvaliacaoFisica.getNumero_avaliacao() + 1);
		}
		
		//Feito desta forma não estava atribuindo os valores e estava sem tempo de verificar
		//não alterar :/
		
		if(auxAvaliacaoFisica.getPerimetro().getCintura() == 0.0 || auxAvaliacaoFisica.getPerimetro().getQuadril() == 0.0) {
			this.auxAvaliacaoFisica.setValorCinturaQuadril(0.0D);
		}
		
		
		avaliacaoFisica = auxAvaliacaoFisica;
		try{
			//Insere dados nas tabelas armazenando o id gerado nos valores
			avaliacaoFisica.getAnamnese().setIdanamnese(anamneseDAO.inserir(avaliacaoFisica.getAnamnese()));
			avaliacaoFisica.getPerimetro().setIdperimetro(perimetroDAO.inserir(avaliacaoFisica.getPerimetro()));
			avaliacaoFisica.getDobraCutanea().setIddobraCutanea(dobraCutaneaDAO.inserir(avaliacaoFisica.getDobraCutanea()));
			avaliacaoFisica.getDiametro().setIddiametro(diametroDAO.inserir(avaliacaoFisica.getDiametro()));
			avaliacaoFisica.getTesteAvaliacao().setId(testeAvaliacaoDao.inserir(avaliacaoFisica.getTesteAvaliacao()));
			avaliacaoFisica.getDesvioPostural().setId(desvioPosturalDao.inserir(avaliacaoFisica.getDesvioPostural()));
			
			//Seta os novos valores na avaliação
			avaliacaoFisica.setData(new Date());
			avaliacaoFisica.setAluno(aluno);
			avaliacaoFisicaDAO.inserir(avaliacaoFisica);
			
			JSFUtil.addMensagensSucesso("Salvo com sucesso");
			
			avaliacoesFisicas = avaliacaoFisicaDAO.consultar(sql  + aluno.getIdAluno() + " ORDER BY avaliacao.numero_avaliacao");
			
			Ajax.update("frmAvaliacao:tabView:tblAvaliacoes");
			btnNovoVisibility = true;
			realoadLines();
		}catch(Exception e){
			e.printStackTrace();
			JSFUtil.addMensagensErro("Falha ao salvar avaliação.");
		}
	}
	

	
	public void botaoNovoActionClick(){
		if (aluno.getIdAluno() > 0) {
			auxAvaliacaoFisica = new AvaliacaoFisica();
			this.auxAvaliacaoFisica = new AvaliacaoFisica();
			this.auxAvaliacaoFisica.setAluno(this.aluno);
			this.auxAvaliacaoFisica.setData(new Date());
			this.btnNovoVisibility = false;
			realoadLines();
			
			if(aluno.getData_nascimento() != null){
				try {
					this.auxAvaliacaoFisica.setIdade_atual(calculaIdadeAluno(this.aluno.getData_nascimento(), new Date()));
				} catch (Exception e) {
					e.printStackTrace();
				}
			}
			
			avaliacoesFisicas = avaliacaoFisicaDAO.consultar(sql  + aluno.getIdAluno() + " ORDER BY avaliacao.numero_avaliacao");
			if (avaliacoesFisicas.size() > 0) {
				//última avaliacao fisica do aluno
				AvaliacaoFisica tmpAvaliacaoFisica = this.avaliacoesFisicas.get(this.avaliacoesFisicas.size() - 1);
				this.auxAvaliacaoFisica.setNumero_avaliacao(tmpAvaliacaoFisica.getNumero_avaliacao() + 1);
				this.auxAvaliacaoFisica.setPeso_atual(tmpAvaliacaoFisica.getPeso_atual());
				this.auxAvaliacaoFisica.setAltura(tmpAvaliacaoFisica.getAltura());
				this.auxAvaliacaoFisica.setAnamnese(tmpAvaliacaoFisica.getAnamnese());
				
				calculaIMC();
			}else
				this.auxAvaliacaoFisica.setNumero_avaliacao(1);
		
			avaliacaoFisica = auxAvaliacaoFisica;
		} else {
			JSFUtil.addMensagensErro("Selecione um aluno");
		}
	}
	 
	public void buscaAvaliacoesAluno(){
		auxAvaliacaoFisica = new AvaliacaoFisica();
		if (aluno.getIdAluno() > 0) {
			realoadLines();
			aluno = alunoDao.findById(aluno.getIdAluno());
			auxAvaliacaoFisica.setAluno(aluno);
			if(aluno.getData_nascimento() != null){
				try {
					auxAvaliacaoFisica = auxAvaliacaoFisica == null ? new AvaliacaoFisica() : auxAvaliacaoFisica;
					auxAvaliacaoFisica.setIdade_atual(calculaIdadeAluno(aluno.getData_nascimento(), new Date()));
				} catch (Exception e) {
					e.printStackTrace();
				}
			}
			
			avaliacoesFisicas = avaliacaoFisicaDAO.consultar(sql  + aluno.getIdAluno() + " ORDER BY avaliacao.numero_avaliacao");
			
			if(avaliacoesFisicas.size() > 0){
				auxAvaliacaoFisica = avaliacoesFisicas.get(avaliacoesFisicas.size() - 1);
			}
			this.avaliacaoFisica = auxAvaliacaoFisica;
		}
	}
	
	public void filtraDataTablePData(){
		if (filtroDe != null && filtroAte != null) {
			SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd");
			avaliacoesFisicas = avaliacaoFisicaDAO.consultar(sql
									    +   aluno.getIdAluno() + " AND avaliacao.data BETWEEN ('"+sdf.format(filtroDe) 
									    + "') AND ('"+sdf.format(filtroAte)+"') ORDER BY avaliacao.numero_avaliacao");
		
		}else
			JSFUtil.addMensagensErro("Preencher os campos 'De' e  'Até' para efetuar a busca.");
	}
	
	public int calculaIdadeAluno(Date dataDe, Date dataAte){
	    long diferencaAnos = ((dataAte.getTime() - dataDe.getTime()) / (1000*60*60*24) / 30) / 12;
	    int idade = Integer.parseInt(""+diferencaAnos);
	    return idade;
	}
	
	public void imprimir(){
		try{
			RequestContext context = RequestContext.getCurrentInstance();
			String caminhoImagem = AutenticacaoMB.loadImageAcademia(academia);
			String caminhoReport = "";
			
			if(optionReport == 0){
				caminhoReport = Faces.getRealPath("/reports/avaliacao/avaliacao_bobina.jasper");
				context.execute("window.open('" +Faces.getRequestContextPath() 
														+ "/pages/pdf.xhtml?faces-redirect=true&jrxml=" 
														+ URLEncoder.encode(caminhoReport, "UTF-8") + ""
					                                    + "&idavaliacao="+auxAvaliacaoFisica.getIdavaliacao_fisica()+""
							                            + "&caminhoimagem="+URLEncoder.encode(caminhoImagem, "UTF-8")+"')");
			}else{
				caminhoReport = Faces.getRealPath("/reports/avaliacao/avaliacao_fisica.jasper");	
				context.execute("window.open('" +Faces.getRequestContextPath()
						+ "/pages/pdf.xhtml?faces-redirect=true"
						+ "&jrxml=" + URLEncoder.encode(caminhoReport, "UTF-8") + ""
						+ "&idavaliacao="+auxAvaliacaoFisica.getIdavaliacao_fisica()
					    + "&caminhoimagem="+URLEncoder.encode(caminhoImagem, "UTF-8")+"')");
			}
		}catch(Exception e){
			e.printStackTrace();
		}
	}
	
	public void calculaIMC(){
		if(auxAvaliacaoFisica != null){
			if (auxAvaliacaoFisica.getPeso_atual() > 0 && auxAvaliacaoFisica.getAltura() > 0 ) {
				double imc= NutricaoUtil.calculaIMC(auxAvaliacaoFisica.getPeso_atual(), auxAvaliacaoFisica.getAltura());
				this.auxAvaliacaoFisica.setImc(imc);
				System.out.println("Resultado do imc : " + imc);
				this.auxAvaliacaoFisica.setResultado_imc(NutricaoUtil.resultadoIMC(imc));
				System.out.println("Nutrição util : " + NutricaoUtil.resultadoIMC(imc));
			}
		}
	}
	 
	public void calculaMedia(int opcao){
		switch (opcao) {
		case 1:
			double[] biceps = new double[]{auxAvaliacaoFisica.getDobraCutanea().getBiceps1(),
					  auxAvaliacaoFisica.getDobraCutanea().getBiceps2(),
					  auxAvaliacaoFisica.getDobraCutanea().getBiceps3()};
			auxAvaliacaoFisica.getDobraCutanea().setBiceps_media(calculaValorMediana(biceps));
			break;
		case 2:
			double[] triceps = new double[]{auxAvaliacaoFisica.getDobraCutanea().getTriceps1(),
					  auxAvaliacaoFisica.getDobraCutanea().getTriceps2(),
				      auxAvaliacaoFisica.getDobraCutanea().getTriceps3()};
			auxAvaliacaoFisica.getDobraCutanea().setTriceps_media(calculaValorMediana(triceps));
			break;
		case 3:
			double[] torax = new double[]{auxAvaliacaoFisica.getDobraCutanea().getTorax1(),
					  auxAvaliacaoFisica.getDobraCutanea().getTorax2(),
					  auxAvaliacaoFisica.getDobraCutanea().getTorax3()};
			auxAvaliacaoFisica.getDobraCutanea().setTorax_media(calculaValorMediana(torax));
			break;
		case 4:
			double[] subEscupular = new double[]{auxAvaliacaoFisica.getDobraCutanea().getSubescapular1(),
					  auxAvaliacaoFisica.getDobraCutanea().getSubescapular2(),
					  auxAvaliacaoFisica.getDobraCutanea().getSubescapular3()};
			auxAvaliacaoFisica.getDobraCutanea().setSubescapular_media(calculaValorMediana(subEscupular));
			break;
		case 5:
			double[] axiliarMedia = new double[]{auxAvaliacaoFisica.getDobraCutanea().getAxiliar_media1(),
					  auxAvaliacaoFisica.getDobraCutanea().getAxiliar_media2(),
					  auxAvaliacaoFisica.getDobraCutanea().getAxiliar_media3()};
			auxAvaliacaoFisica.getDobraCutanea().setAxiliar_media_media(calculaValorMediana(axiliarMedia));
			break;
		case 6:
			double[] supraIlica = new double[]{auxAvaliacaoFisica.getDobraCutanea().getSupra_iliaca1(),
					  auxAvaliacaoFisica.getDobraCutanea().getSupra_iliaca2(),
					  auxAvaliacaoFisica.getDobraCutanea().getSupra_iliaca3()};
			auxAvaliacaoFisica.getDobraCutanea().setSupra_iliaca_media(calculaValorMediana(supraIlica));
			break;
		case 7:
			double[] abdominal = new double[]{auxAvaliacaoFisica.getDobraCutanea().getAbdominal1(),
					  auxAvaliacaoFisica.getDobraCutanea().getAbdominal2(),
					  auxAvaliacaoFisica.getDobraCutanea().getAbdominal3()};
			auxAvaliacaoFisica.getDobraCutanea().setAbdominal_media(calculaValorMediana(abdominal));
			break;
		case 8:
			double[] coxaMedial = new double[]{auxAvaliacaoFisica.getDobraCutanea().getCoxa_medial1(),
					  auxAvaliacaoFisica.getDobraCutanea().getCoxa_medial2(),
					  auxAvaliacaoFisica.getDobraCutanea().getCoxa_medial3()};
			auxAvaliacaoFisica.getDobraCutanea().setCoxa_medial_media(calculaValorMediana(coxaMedial));
			break;
		case 9:
			double[] pantuMedial = new double[]{auxAvaliacaoFisica.getDobraCutanea().getPantu_medial1(),
					  auxAvaliacaoFisica.getDobraCutanea().getPantu_medial2(),
					  auxAvaliacaoFisica.getDobraCutanea().getPantu_medial3()};
			auxAvaliacaoFisica.getDobraCutanea().setPantu_medial_media(calculaValorMediana(pantuMedial));
			break;
		case 10:
			double[] supraEspinal = new double[]{auxAvaliacaoFisica.getDobraCutanea().getSupra_espinal1(),
					  auxAvaliacaoFisica.getDobraCutanea().getSupra_espinal2(),
					  auxAvaliacaoFisica.getDobraCutanea().getSupra_espinal3()};
			auxAvaliacaoFisica.getDobraCutanea().setSupra_espinal_media(calculaValorMediana(supraEspinal));
			
			break;
		}
	}
	
	public double calculaValorMediana(double[] vetor){
		if(vetor[0] == 0 && vetor[1] == 0 && vetor[2] == 0)
			return 0;
		
		if(vetor[0] > 0 && vetor[1] == 0 && vetor[2] == 0)
			return 0;
		
		if(vetor[0] > 0 && vetor[1] > 0 && vetor[2] == 0){
			if (vetor[0] < vetor[1]) 
				return vetor[1];
			if(vetor[1] < vetor[0])
				return vetor[0];
			else
				return vetor[0];
		}
		
		if(vetor[0] > 0 && vetor[1] > 0 && vetor[2] > 0){
			if (vetor[0] == vetor[1])
				return vetor[0];
			if (vetor[1] == vetor[2])
				return vetor[1];
			
			if (vetor[0] < vetor[1] && vetor[1] < vetor[2])
				return vetor[1];
			
			if(vetor[0] > vetor[1] && vetor[1] < vetor[2])
				return vetor[1];
			
			vetor = NutricaoUtil.ordenaVetor(vetor);
			return vetor[1];
		}
		return 0;
	}

	public void calculaMassaOssea(){
		if ( this.auxAvaliacaoFisica.getAltura() > 0) {
			double mo = NutricaoUtil.calculoMassaOssea(
					  this.auxAvaliacaoFisica.getAltura(), 
					  this.auxAvaliacaoFisica.getDiametro().getBiestiloide(), 
					  this.auxAvaliacaoFisica.getDiametro().getBiepicondilo_umeral(), 
					  this.auxAvaliacaoFisica.getDiametro().getBiepicondilo_femeral(),
					  this.auxAvaliacaoFisica.getDiametro().getBimaleolar());
			this.auxAvaliacaoFisica.setPeso_magro_osseo(mo);			
		}
	}
	
	public void calculaMassaResidual(){
		if (auxAvaliacaoFisica.getPeso_atual() > 0) {
			this.auxAvaliacaoFisica.setPeso_magro_residual(
		             NutricaoUtil.calculoMassaResidual(aluno.getGenero().toLowerCase(),
		            		                           auxAvaliacaoFisica.getPeso_atual()));
		}
	}
	
	public void calculaMassaMuscular(){
		if (this.auxAvaliacaoFisica.getPeso_atual() > 0) {
			double peso_muscular = NutricaoUtil.calculoMassaMuscular(
					this.auxAvaliacaoFisica.getPeso_atual(),
					this.auxAvaliacaoFisica.getResultado_peso_gordo(),
					this.auxAvaliacaoFisica.getPeso_magro_osseo(),
					this.auxAvaliacaoFisica.getPeso_magro_residual());
			this.auxAvaliacaoFisica.setPeso_magro_muscular(peso_muscular);
			this.auxAvaliacaoFisica.setPeso_magro_perc_muscular(((peso_muscular * 100) / this.auxAvaliacaoFisica.getPeso_atual()));	
		}
	}
	
	public double calculaPesoGordo(double gordura){
		return NutricaoUtil.calculoMassaCorporalGorda(auxAvaliacaoFisica.getPeso_atual(), gordura);
	}
	
	public void calculaGorduraFalkner(){
		realoadLines();
		linha2 = true;
		linha4 = true;
		linha6 = true;
		linha7 = true;
		
		
		double falkner = NutricaoUtil.percentualGorduraFalkner(
				this.auxAvaliacaoFisica.getDobraCutanea().getTriceps_media(),
				this.auxAvaliacaoFisica.getDobraCutanea().getSubescapular_media(),
				this.auxAvaliacaoFisica.getDobraCutanea().getSupra_iliaca_media(),
				this.auxAvaliacaoFisica.getDobraCutanea().getAbdominal_media());
			
		
		this.auxAvaliacaoFisica.setResultado_gordura_atual(falkner);
		this.auxAvaliacaoFisica.setResultado_peso_gordo(calculaPesoGordo(falkner));
		this.auxAvaliacaoFisica.setResultado_peso_magro(
		NutricaoUtil.calculoMassaCorporalMagraKG(auxAvaliacaoFisica.getPeso_atual(), 
												 auxAvaliacaoFisica.getResultado_peso_gordo()));
		
		
		
		this.auxAvaliacaoFisica.setProtocolo("Falkner");
		calculaGorduraCorporalIdealMaxMin();
		
		
		Double resultadoMinimo = this.auxAvaliacaoFisica.getResultado_gordura_ideal_minimo();
		Double resultadoAtual = this.auxAvaliacaoFisica.getResultado_gordura_atual();
		
		Double resultado = (this.auxAvaliacaoFisica.getPeso_atual() * resultadoAtual) / 100;
		DecimalFormat format = new DecimalFormat("0.0");
		
		String pesoAtual = format.format(resultado);
		String replace = pesoAtual.replace(",", ".");
		
		auxAvaliacaoFisica.setResultadoPesoGorduraAtual(Double.valueOf(replace));
		
		Double resultadoIdeal = (auxAvaliacaoFisica.getPeso_atual() * resultadoMinimo) / 100;
		String resultadoPesoMinimo = format.format(resultadoIdeal);
		String replace2 = resultadoPesoMinimo.replace(",", ".");
		
		auxAvaliacaoFisica.setResultadoPesoGorduraIdeal(Double.valueOf(replace2));
		
	/*	settarQuilosMinimo();
		settarQuilosGorduraAtual(); */
		
	/*	this.avaliacaoFisica.setResultado_gordura_ideal_minimo(this.avaliacaoFisica.getResultado_gordura_ideal_minimo());
		this.avaliacaoFisica.setResultado_gordura_atual(this.avaliacaoFisica.getResultado_gordura_atual());
		this.auxAvaliacaoFisica.setResultado_gordura_ideal_minimo(this.auxAvaliacaoFisica.getResultado_gordura_ideal_minimo());
		this.auxAvaliacaoFisica.setResultado_gordura_atual(this.auxAvaliacaoFisica.getResultado_gordura_atual());
		
		System.out.println(auxAvaliacaoFisica.getResultado_gordura_atual());
		System.out.println(auxAvaliacaoFisica.getResultado_gordura_ideal_minimo()); */
	
	}
	
	public void calculaDCGuedes(){
		
		realoadLines();
		
		if(aluno.getGenero().toLowerCase().equals("masculino")){
			linha2 = true;
			linha6 = true;
			linha7 = true;
		}else{
			linha8 = true;
			linha6 = true;
			linha4 = true;
		}
		
		double guedes = NutricaoUtil.calculoDCGuedes(aluno.getGenero().toLowerCase(), 
												    this.auxAvaliacaoFisica.getDobraCutanea().getTriceps_media(), 
												    this.auxAvaliacaoFisica.getDobraCutanea().getSupra_iliaca_media(), 
												    this.auxAvaliacaoFisica.getDobraCutanea().getAbdominal_media(), 
												    this.auxAvaliacaoFisica.getDobraCutanea().getCoxa_medial_media(), 
												    this.auxAvaliacaoFisica.getDobraCutanea().getSupra_iliaca_media(), 
												    this.auxAvaliacaoFisica.getDobraCutanea().getSubescapular_media());
		
		double dc = NutricaoUtil.percentualGorduraSiri(guedes);
		
		this.auxAvaliacaoFisica.setResultado_gordura_atual(dc);
		this.auxAvaliacaoFisica.setResultado_peso_gordo(NutricaoUtil.calculaGorduraAbsGuedesKg(auxAvaliacaoFisica.getPeso_atual(),dc));
		this.auxAvaliacaoFisica.setResultado_peso_magro(NutricaoUtil.calculaMassaMagrasGuedesKg(auxAvaliacaoFisica.getPeso_atual(), this.auxAvaliacaoFisica.getResultado_peso_gordo()));
		calculaMassaResidual();
		calculaMassaMuscular();
		this.auxAvaliacaoFisica.setProtocolo("Guedes 3 Dobras");
		calculaGorduraCorporalIdealMaxMin();
		
		Double resultadoMinimo = this.auxAvaliacaoFisica.getResultado_gordura_ideal_minimo();
		Double resultadoAtual = this.auxAvaliacaoFisica.getResultado_gordura_atual();
		
		Double resultado = (this.auxAvaliacaoFisica.getPeso_atual() * resultadoAtual) / 100;
		DecimalFormat format = new DecimalFormat("0.0");
		
		String pesoAtual = format.format(resultado);
		String replace = pesoAtual.replace(",", ".");
		
		auxAvaliacaoFisica.setResultadoPesoGorduraAtual(Double.valueOf(replace));
		
		Double resultadoIdeal = (auxAvaliacaoFisica.getPeso_atual() * resultadoMinimo) / 100;
		String resultadoPesoMinimo = format.format(resultadoIdeal);
		String replace2 = resultadoPesoMinimo.replace(",", ".");
		
		auxAvaliacaoFisica.setResultadoPesoGorduraIdeal(Double.valueOf(replace2));
	}
	
	
	public void calculoDCJacksonPollock3Dobras(){
		double dc3Jackson = 0;
		double gorduraSiri = 0;
		if (aluno.getGenero().equals("Masculino")) {
			dc3Jackson	= NutricaoUtil.calculoDCJacksonPollock3DobrasMasc(
									this.auxAvaliacaoFisica.getIdade_atual(), 
									this.auxAvaliacaoFisica.getDobraCutanea().getTorax_media(), 
									this.auxAvaliacaoFisica.getDobraCutanea().getAbdominal_media(), 
									this.auxAvaliacaoFisica.getDobraCutanea().getCoxa_medial_media());
			gorduraSiri = NutricaoUtil.percentualGorduraSiriLohman(
					this.auxAvaliacaoFisica.getIdade_atual(),"masculino",dc3Jackson);
		}else 
		 if (aluno.getGenero().equals("Feminino")){
				dc3Jackson	= NutricaoUtil.calculoDCJacksonPollock3DobrasFemin(
						this.auxAvaliacaoFisica.getIdade_atual(), 
						this.auxAvaliacaoFisica.getDobraCutanea().getTriceps_media(),
						this.auxAvaliacaoFisica.getDobraCutanea().getSupra_iliaca_media(), 
						this.auxAvaliacaoFisica.getDobraCutanea().getCoxa_medial_media());		
				gorduraSiri = NutricaoUtil.percentualGorduraSiriLohman(
						this.auxAvaliacaoFisica.getIdade_atual(),"feminino",dc3Jackson);
		 }
		this.auxAvaliacaoFisica.setResultado_gordura_atual(gorduraSiri);		
		this.auxAvaliacaoFisica.setResultado_peso_gordo(calculaPesoGordo(gorduraSiri));
		this.auxAvaliacaoFisica.setResultado_peso_magro(
		NutricaoUtil.calculoMassaCorporalMagraKG(auxAvaliacaoFisica.getPeso_atual(), 
																				auxAvaliacaoFisica.getResultado_peso_gordo()));
		calculaMassaResidual();
		calculaMassaMuscular();
		this.auxAvaliacaoFisica.setProtocolo("Jackson Pollock 3 Dobras");
		calculaGorduraCorporalIdealMaxMin();
		
		Double resultadoMinimo = this.auxAvaliacaoFisica.getResultado_gordura_ideal_minimo();
		Double resultadoAtual = this.auxAvaliacaoFisica.getResultado_gordura_atual();
		
		Double resultado = (this.auxAvaliacaoFisica.getPeso_atual() * resultadoAtual) / 100;
		DecimalFormat format = new DecimalFormat("0.0");
		
		String pesoAtual = format.format(resultado);
		String replace = pesoAtual.replace(",", ".");
		
		auxAvaliacaoFisica.setResultadoPesoGorduraAtual(Double.valueOf(replace));
		
		Double resultadoIdeal = (auxAvaliacaoFisica.getPeso_atual() * resultadoMinimo) / 100;
		String resultadoPesoMinimo = format.format(resultadoIdeal);
		String replace2 = resultadoPesoMinimo.replace(",", ".");
		
		auxAvaliacaoFisica.setResultadoPesoGorduraIdeal(Double.valueOf(replace2));
		
		realoadLines();
		linha3 = true;
		linha7 = true;
		linha8 = true;
	}
	public void calculoDCJacksonPollock7Dobras(){
		double dc7Jackson = 0;
		double gorduraSiri = 0;
		if (aluno.getGenero().equals("Masculino")) {
		dc7Jackson	= NutricaoUtil.calculoDCJacksonPollock7DobrasMasc(
					this.auxAvaliacaoFisica.getIdade_atual(), 
					this.auxAvaliacaoFisica.getDobraCutanea().getTorax_media(), 
					this.auxAvaliacaoFisica.getDobraCutanea().getAxiliar_media_media(),
					this.auxAvaliacaoFisica.getDobraCutanea().getTriceps_media(),
					this.auxAvaliacaoFisica.getDobraCutanea().getSubescapular_media(),
					this.auxAvaliacaoFisica.getDobraCutanea().getAbdominal_media(),
					this.auxAvaliacaoFisica.getDobraCutanea().getSupra_iliaca_media(),
					this.auxAvaliacaoFisica.getDobraCutanea().getCoxa_medial_media());
			gorduraSiri = NutricaoUtil.percentualGorduraSiriLohman(
					this.auxAvaliacaoFisica.getIdade_atual(), "masculino", dc7Jackson);
		}else 
		 if (aluno.getGenero().equals("Feminino")){
				dc7Jackson	= NutricaoUtil.calculoDCJacksonPollock7DobrasFemin(
						this.auxAvaliacaoFisica.getIdade_atual(), 
						this.auxAvaliacaoFisica.getDobraCutanea().getTorax_media(), 
						this.auxAvaliacaoFisica.getDobraCutanea().getAxiliar_media_media(),
						this.auxAvaliacaoFisica.getDobraCutanea().getTriceps_media(),
						this.auxAvaliacaoFisica.getDobraCutanea().getSubescapular_media(),
						this.auxAvaliacaoFisica.getDobraCutanea().getAbdominal_media(),
						this.auxAvaliacaoFisica.getDobraCutanea().getSupra_iliaca_media(),
						this.auxAvaliacaoFisica.getDobraCutanea().getCoxa_medial_media());		
				gorduraSiri = NutricaoUtil.percentualGorduraSiriLohman(
						this.auxAvaliacaoFisica.getIdade_atual(), "feminino", dc7Jackson);
		 }
		this.auxAvaliacaoFisica.setResultado_gordura_atual(gorduraSiri);
		this.auxAvaliacaoFisica.setResultado_peso_gordo(calculaPesoGordo(gorduraSiri));
		this.auxAvaliacaoFisica.setResultado_peso_magro(
		NutricaoUtil.calculoMassaCorporalMagraKG(auxAvaliacaoFisica.getPeso_atual(), 
																				auxAvaliacaoFisica.getResultado_peso_gordo()));
		calculaMassaResidual();
		calculaMassaMuscular();
		this.auxAvaliacaoFisica.setProtocolo("Jackson Pollock 7 Dobras");
		calculaGorduraCorporalIdealMaxMin();
		
		Double resultadoMinimo = this.auxAvaliacaoFisica.getResultado_gordura_ideal_minimo();
		Double resultadoAtual = this.auxAvaliacaoFisica.getResultado_gordura_atual();
		
		Double resultado = (this.auxAvaliacaoFisica.getPeso_atual() * resultadoAtual) / 100;
		DecimalFormat format = new DecimalFormat("0.0");
		
		String pesoAtual = format.format(resultado);
		String replace = pesoAtual.replace(",", ".");
		
		auxAvaliacaoFisica.setResultadoPesoGorduraAtual(Double.valueOf(replace));
		
		Double resultadoIdeal = (auxAvaliacaoFisica.getPeso_atual() * resultadoMinimo) / 100;
		String resultadoPesoMinimo = format.format(resultadoIdeal);
		String replace2 = resultadoPesoMinimo.replace(",", ".");
		
		auxAvaliacaoFisica.setResultadoPesoGorduraIdeal(Double.valueOf(replace2));
		
		realoadLines();
		linha3 = true;
		linha5 = true;
		linha2 = true;
		linha4 = true;
		linha7 = true;
		linha6 = true;
		linha8 = true;
	}
	
	public void calculoJacksonPollockWard3Dobras(){
		double dc3Jackson = 0;
		double gorduraSiri = 0;
		/*if (aluno.getGenero().equals("Masculino")) {
				JSFUtil.addMensagensErro("Está fórmula não é aplicavel para este paciente.");
		}else */ 
		//if (aluno.getGenero().equals("Feminino")){
			dc3Jackson = NutricaoUtil.calculoDCJacksonPollockWard3DobrasFemin(
					this.auxAvaliacaoFisica.getIdade_atual(),
					this.auxAvaliacaoFisica.getDobraCutanea().getTorax_media(),
					this.auxAvaliacaoFisica.getDobraCutanea().getAbdominal_media(),
					this.auxAvaliacaoFisica.getDobraCutanea().getCoxa_medial_media());
			gorduraSiri = NutricaoUtil.percentualGorduraSiriLohman(
					this.auxAvaliacaoFisica.getIdade_atual(), "feminino", dc3Jackson);
		//}
		this.auxAvaliacaoFisica.setResultado_gordura_atual(gorduraSiri);
		this.auxAvaliacaoFisica.setResultado_peso_gordo(calculaPesoGordo(gorduraSiri));
		this.auxAvaliacaoFisica.setResultado_peso_magro(
		NutricaoUtil.calculoMassaCorporalMagraKG(auxAvaliacaoFisica.getPeso_atual(), 
																				auxAvaliacaoFisica.getResultado_peso_gordo())); 
		calculaMassaResidual();
		calculaMassaMuscular();
		this.auxAvaliacaoFisica.setProtocolo("Jackson, Pollock & Ward 3 Dobras");
		calculaGorduraCorporalIdealMaxMin();

		Double resultadoMinimo = this.auxAvaliacaoFisica.getResultado_gordura_ideal_minimo();
		Double resultadoAtual = this.auxAvaliacaoFisica.getResultado_gordura_atual();
		
		Double resultado = (this.auxAvaliacaoFisica.getPeso_atual() * resultadoAtual) / 100;
		DecimalFormat format = new DecimalFormat("0.0");
		
		String pesoAtual = format.format(resultado);
		String replace = pesoAtual.replace(",", ".");
		
		auxAvaliacaoFisica.setResultadoPesoGorduraAtual(Double.valueOf(replace));
		
		Double resultadoIdeal = (auxAvaliacaoFisica.getPeso_atual() * resultadoMinimo) / 100;
		String resultadoPesoMinimo = format.format(resultadoIdeal);
		String replace2 = resultadoPesoMinimo.replace(",", ".");
		
		auxAvaliacaoFisica.setResultadoPesoGorduraIdeal(Double.valueOf(replace2));
		
		realoadLines();
		linha3 = true;
		linha7 = true;
		linha8 = true;
	}
	
	public void calculoJacksonPollockWard7Dobras(){
		double dc7Jackson = 0;
		double gorduraSiri = 0;
	/*	if (aluno.getGenero().equals("Masculino")) {
			JSFUtil.addMensagensErro("Está fórmula não é aplicavel para este paciente.");
		}else */  
		// if (aluno.getGenero().equals("Feminino")){
			 	dc7Jackson	= NutricaoUtil.calculoDCJacksonPollock7DobrasFemin(
				auxAvaliacaoFisica.getIdade_atual(), 
				auxAvaliacaoFisica.getDobraCutanea().getTorax_media(), 
				auxAvaliacaoFisica.getDobraCutanea().getAxiliar_media_media(),
				auxAvaliacaoFisica.getDobraCutanea().getTriceps_media(),
				auxAvaliacaoFisica.getDobraCutanea().getSubescapular_media(),
				auxAvaliacaoFisica.getDobraCutanea().getAbdominal_media(),
				auxAvaliacaoFisica.getDobraCutanea().getSupra_iliaca_media(),
				auxAvaliacaoFisica.getDobraCutanea().getCoxa_medial_media());		
			 	gorduraSiri = NutricaoUtil.percentualGorduraSiriLohman(auxAvaliacaoFisica.getIdade_atual(), "feminino", dc7Jackson);
		// }
		auxAvaliacaoFisica.setResultado_gordura_atual(gorduraSiri);
		auxAvaliacaoFisica.setResultado_peso_gordo(calculaPesoGordo(gorduraSiri));
		auxAvaliacaoFisica.setResultado_peso_magro(
		NutricaoUtil.calculoMassaCorporalMagraKG(auxAvaliacaoFisica.getPeso_atual(), 
																				auxAvaliacaoFisica.getResultado_peso_gordo())); 
		calculaMassaResidual();
		calculaMassaMuscular();
		this.auxAvaliacaoFisica.setProtocolo("Jackson, Pollock & Ward 7 Dobras");
		calculaGorduraCorporalIdealMaxMin();
		
		Double resultadoMinimo = this.auxAvaliacaoFisica.getResultado_gordura_ideal_minimo();
		Double resultadoAtual = this.auxAvaliacaoFisica.getResultado_gordura_atual();
		
		Double resultado = (this.auxAvaliacaoFisica.getPeso_atual() * resultadoAtual) / 100;
		DecimalFormat format = new DecimalFormat("0.0");
		
		String pesoAtual = format.format(resultado);
		String replace = pesoAtual.replace(",", ".");
		
		auxAvaliacaoFisica.setResultadoPesoGorduraAtual(Double.valueOf(replace));
		
		Double resultadoIdeal = (auxAvaliacaoFisica.getPeso_atual() * resultadoMinimo) / 100;
		String resultadoPesoMinimo = format.format(resultadoIdeal);
		String replace2 = resultadoPesoMinimo.replace(",", ".");
		
		auxAvaliacaoFisica.setResultadoPesoGorduraIdeal(Double.valueOf(replace2));
		
		realoadLines();
		linha3 = true;
		linha5 = true;
		linha2 = true;
		linha4 = true;
		linha7 = true;
		linha6 = true;
		linha8 = true;
	}
	
	public void calculaDCDurningWomersley(int equacao){
		double gorduraSiri = 0;
		double dcDurning = 0;
		double triceps = auxAvaliacaoFisica.getDobraCutanea().getTriceps_media();
		double biceps = auxAvaliacaoFisica.getDobraCutanea().getBiceps_media();
		double subEscapular = auxAvaliacaoFisica.getDobraCutanea().getSubescapular_media();
		double supraIliaca = auxAvaliacaoFisica.getDobraCutanea().getSupra_iliaca_media();
		
		if(auxAvaliacaoFisica.getIdade_atual() == 0.0){
			JSFUtil.addMensagensErro("Ïdade não pode ser 0");
			return;
		}
		
		if (triceps > 0 && biceps > 0 && subEscapular  > 0 && supraIliaca > 0) {
			if (aluno.getGenero().toLowerCase().equals("masculino")) {
				switch (equacao) {
				case 1:
					dcDurning = NutricaoUtil.calculoDurningWomersley17_19_Masc(triceps, biceps, subEscapular,supraIliaca);
					gorduraSiri = NutricaoUtil.percentualGorduraSiriLohman(auxAvaliacaoFisica.getIdade_atual(), aluno.getGenero().toLowerCase(), dcDurning);
					break;
				case 2:
					dcDurning = NutricaoUtil.calculoDurningWomersley20_29_Masc(triceps, biceps, subEscapular,supraIliaca);
					gorduraSiri = NutricaoUtil.percentualGorduraSiriLohman(auxAvaliacaoFisica.getIdade_atual(), aluno.getGenero().toLowerCase(), dcDurning);
				break;
				case 3:
					dcDurning = NutricaoUtil.calculoDurningWomersley30_39_Masc(triceps, biceps, subEscapular,supraIliaca);	
					gorduraSiri = NutricaoUtil.percentualGorduraSiriLohman(auxAvaliacaoFisica.getIdade_atual(), aluno.getGenero().toLowerCase(), dcDurning);
					break;
				case 4:
					dcDurning = NutricaoUtil.calculoDurningWomersley40_49_Masc(triceps, biceps, subEscapular,supraIliaca);	
					gorduraSiri = NutricaoUtil.percentualGorduraSiriLohman(auxAvaliacaoFisica.getIdade_atual(), aluno.getGenero().toLowerCase(), dcDurning);
					break;
				case 5:
					dcDurning = NutricaoUtil.calculoDurningWomersley50_72_Masc(triceps, biceps, subEscapular,supraIliaca);	
					gorduraSiri = NutricaoUtil.percentualGorduraSiriLohman(auxAvaliacaoFisica.getIdade_atual(), aluno.getGenero().toLowerCase(), dcDurning);
					break;	
				}
			}else if(aluno.getGenero().toLowerCase().equals("feminino")){
				switch (equacao) {
				case 1:
					dcDurning = NutricaoUtil.calculoDurningWomersley16_19_Femin(triceps, biceps, subEscapular,supraIliaca);
					gorduraSiri = NutricaoUtil.percentualGorduraSiriLohman(auxAvaliacaoFisica.getIdade_atual(), aluno.getGenero().toLowerCase(), dcDurning);
					break;
				case 2:
					dcDurning = NutricaoUtil.calculoDurningWomersley20_29_Femin(triceps, biceps, subEscapular,supraIliaca);	
					gorduraSiri = NutricaoUtil.percentualGorduraSiriLohman(auxAvaliacaoFisica.getIdade_atual(), aluno.getGenero().toLowerCase(), dcDurning);
					break;
				case 3:
					dcDurning = NutricaoUtil.calculoDurningWomersley30_39_Femin(triceps, biceps, subEscapular,supraIliaca);		
				gorduraSiri = NutricaoUtil.percentualGorduraSiriLohman(auxAvaliacaoFisica.getIdade_atual(), aluno.getGenero().toLowerCase(), dcDurning);
				break;
				case 4:
					dcDurning = NutricaoUtil.calculoDurningWomersley40_49_Femin(triceps, biceps, subEscapular,supraIliaca);	
					gorduraSiri = NutricaoUtil.percentualGorduraSiriLohman(auxAvaliacaoFisica.getIdade_atual(), aluno.getGenero().toLowerCase(), dcDurning);
					break;
				case 5:
					dcDurning = NutricaoUtil.calculoDurningWomersley50_59_Femin(triceps, biceps, subEscapular,supraIliaca);	
					gorduraSiri = NutricaoUtil.percentualGorduraSiriLohman(auxAvaliacaoFisica.getIdade_atual(), aluno.getGenero().toLowerCase(), dcDurning);
					break;				
				}
			}
		}
		this.auxAvaliacaoFisica.setResultado_gordura_atual(gorduraSiri);
		this.auxAvaliacaoFisica.setResultado_peso_gordo(calculaPesoGordo(gorduraSiri));
		double massa_magra = NutricaoUtil.calculoMassaCorporalMagraKG(auxAvaliacaoFisica.getPeso_atual(), 
												 																		 auxAvaliacaoFisica.getResultado_peso_gordo());
		this.auxAvaliacaoFisica.setResultado_peso_magro(massa_magra);	
		calculaMassaResidual();
		calculaMassaMuscular();
		this.auxAvaliacaoFisica.setProtocolo("Durning Womersley");
		calculaGorduraCorporalIdealMaxMin();
		
		Double resultadoMinimo = this.auxAvaliacaoFisica.getResultado_gordura_ideal_minimo();
		Double resultadoAtual = this.auxAvaliacaoFisica.getResultado_gordura_atual();
		
		Double resultado = (this.auxAvaliacaoFisica.getPeso_atual() * resultadoAtual) / 100;
		DecimalFormat format = new DecimalFormat("0.0");
		
		String pesoAtual = format.format(resultado);
		String replace = pesoAtual.replace(",", ".");
		
		auxAvaliacaoFisica.setResultadoPesoGorduraAtual(Double.valueOf(replace));
		
		Double resultadoIdeal = (auxAvaliacaoFisica.getPeso_atual() * resultadoMinimo) / 100;
		String resultadoPesoMinimo = format.format(resultadoIdeal);
		String replace2 = resultadoPesoMinimo.replace(",", ".");
		
		auxAvaliacaoFisica.setResultadoPesoGorduraIdeal(Double.valueOf(replace2));
		
		
		realoadLines();
		linha2 = true;
		linha1 = true;
		linha4 = true;
		linha6 = true;
	}
	
	public void calculoMassaDeurenberg(int calculo){
		double gordura = 0;
		double biceps =  this.auxAvaliacaoFisica.getDobraCutanea().getBiceps_media();
		double triceps =  this.auxAvaliacaoFisica.getDobraCutanea().getTriceps_media();
		double subEscapular = this.auxAvaliacaoFisica.getDobraCutanea().getSubescapular_media();
		double supraIliaca = this.auxAvaliacaoFisica.getDobraCutanea().getSupra_iliaca_media();
		
		switch (calculo) {
		case 1:
			gordura = NutricaoUtil.calculoMCDeurenbergPrePubere(biceps,triceps,subEscapular, supraIliaca);
			if (gordura > 0) {
				this.auxAvaliacaoFisica.setResultado_gordura_atual(gordura);
				this.auxAvaliacaoFisica.setResultado_peso_gordo(calculaPesoGordo(gordura));
				double massa_magra = NutricaoUtil.calculoMassaCorporalMagraKG(auxAvaliacaoFisica.getPeso_atual(), auxAvaliacaoFisica.getResultado_peso_gordo());
				this.auxAvaliacaoFisica.setResultado_peso_magro(massa_magra);	
				calculaMassaResidual();
				calculaMassaMuscular();
				this.auxAvaliacaoFisica.setProtocolo("Deurenberg Pré-Pubere");
				calculaGorduraCorporalIdealMaxMin();
			}
			break;
		case 2:
			gordura = NutricaoUtil.calculoMCDeurenbergPubere(biceps,triceps,subEscapular, supraIliaca);
			if (gordura > 0) {
				this.auxAvaliacaoFisica.setResultado_gordura_atual(gordura);
				this.auxAvaliacaoFisica.setResultado_peso_gordo(calculaPesoGordo(gordura));
				double massa_magra = NutricaoUtil.calculoMassaCorporalMagraKG(auxAvaliacaoFisica.getPeso_atual(), auxAvaliacaoFisica.getResultado_peso_gordo());
				this.auxAvaliacaoFisica.setResultado_peso_magro(massa_magra);
				calculaMassaResidual();
				calculaMassaMuscular();
				this.auxAvaliacaoFisica.setProtocolo("Deurenberg Púbere");
				calculaGorduraCorporalIdealMaxMin();
			}
			break;
		case 3:
			gordura = NutricaoUtil.calculoMCDeurenbergPosPubere(biceps,triceps,subEscapular, supraIliaca);
			if (gordura > 0) {
				this.auxAvaliacaoFisica.setResultado_gordura_atual(gordura);
				this.auxAvaliacaoFisica.setResultado_peso_gordo(calculaPesoGordo(gordura));
				double massa_magra = NutricaoUtil.calculoMassaCorporalMagraKG(auxAvaliacaoFisica.getPeso_atual(), auxAvaliacaoFisica.getResultado_peso_gordo());
				this.auxAvaliacaoFisica.setResultado_peso_magro(massa_magra);
				calculaMassaResidual();
				calculaMassaMuscular();
				this.auxAvaliacaoFisica.setProtocolo("Deurenberg Pós-Pubere");
				calculaGorduraCorporalIdealMaxMin();
			}
			break;	
		}
		
		Double resultadoMinimo = this.auxAvaliacaoFisica.getResultado_gordura_ideal_minimo();
		Double resultadoAtual = this.auxAvaliacaoFisica.getResultado_gordura_atual();
		
		Double resultado = (this.auxAvaliacaoFisica.getPeso_atual() * resultadoAtual) / 100;
		DecimalFormat format = new DecimalFormat("0.0");
		
		String pesoAtual = format.format(resultado);
		String replace = pesoAtual.replace(",", ".");
		
		auxAvaliacaoFisica.setResultadoPesoGorduraAtual(Double.valueOf(replace));
		
		Double resultadoIdeal = (auxAvaliacaoFisica.getPeso_atual() * resultadoMinimo) / 100;
		String resultadoPesoMinimo = format.format(resultadoIdeal);
		String replace2 = resultadoPesoMinimo.replace(",", ".");
		
		auxAvaliacaoFisica.setResultadoPesoGorduraIdeal(Double.valueOf(replace2));
		
	}
	
	public void calculaGorduraCorporalIdealMaxMin(){
		if(aluno.getGenero() != null){
			int genero = aluno.getGenero().equals("Masculino") ? 1 : 2;
			int gordural_ideal = genero == 1 ? 15 : 25;
			
			double diferencaPesoIdeal = NutricaoUtil.calculaDiferencaPesoIdeal(gordural_ideal, auxAvaliacaoFisica.getResultado_gordura_atual());
			double diferencaKG = NutricaoUtil.calculaKgPesoIdealSobrePeso(auxAvaliacaoFisica.getPeso_atual(), diferencaPesoIdeal);
			
			//ADICIONADO MARGEM DE ERRO PARA 1
			if(auxAvaliacaoFisica.getResultado_gordura_atual() > gordural_ideal){
				this.auxAvaliacaoFisica.setResultado_peso_ideal(auxAvaliacaoFisica.getPeso_atual() - diferencaKG + 1);
			}else{
				this.auxAvaliacaoFisica.setResultado_peso_ideal(auxAvaliacaoFisica.getPeso_atual() + diferencaKG + 1);
			}
			
			
			this.auxAvaliacaoFisica.setResultado_gordura_ideal_minimo(gordural_ideal);
			this.auxAvaliacaoFisica.setResultado_gordura_ideal_maximo(Math.abs(diferencaPesoIdeal));
			
		}
	}

	public void realoadLines(){
		linha1 = false;
		linha2 = false;
		linha3 = false;
		linha4 = false;
		linha5 = false;
		linha6 = false;
		linha7 = false;
		linha8 = false;
		linha9 = false;
		linha10 = false;
	}
	
	public BarChartModel calculaGraficoDesvioPostural(){
		int cabeca_pesco = 0, coluna_dorso_lombar = 0, abdome_quadril = 0, membros_inferiores = 0, indice = 0;
		
		cabeca_pesco += auxAvaliacaoFisica.getDesvioPostural().getPescoco_dorsal() != null 
				&& auxAvaliacaoFisica.getDesvioPostural().getPescoco_dorsal().equals("LIGEIRO") ? 8 : 
					auxAvaliacaoFisica.getDesvioPostural().getPescoco_dorsal() != null 
					&& auxAvaliacaoFisica.getDesvioPostural().getPescoco_dorsal().equals("ACENTUADO") ? 14 : 0;
		
		cabeca_pesco += auxAvaliacaoFisica.getDesvioPostural().getPescoco_lateral() != null 
				&& auxAvaliacaoFisica.getDesvioPostural().getPescoco_lateral().equals("LIGEIRO") ? 8 : 
					auxAvaliacaoFisica.getDesvioPostural().getPescoco_lateral() != null 
					&& auxAvaliacaoFisica.getDesvioPostural().getPescoco_lateral().equals("ACENTUADO") ? 14 : 0;
		
		cabeca_pesco += auxAvaliacaoFisica.getDesvioPostural().getOmbro_dorsal() != null 
				&& auxAvaliacaoFisica.getDesvioPostural().getOmbro_dorsal().equals("LIGEIRO") ? 8 : 
					auxAvaliacaoFisica.getDesvioPostural().getOmbro_dorsal() != null 
					&& auxAvaliacaoFisica.getDesvioPostural().getOmbro_dorsal().equals("ACENTUADO") ? 14 : 0;
		
		cabeca_pesco += auxAvaliacaoFisica.getDesvioPostural().getOmbro_escapula_lateral() != null 
				&& auxAvaliacaoFisica.getDesvioPostural().getOmbro_escapula_lateral().equals("LIGEIRO") ? 8 : 
					auxAvaliacaoFisica.getDesvioPostural().getOmbro_escapula_lateral() != null 
					&& auxAvaliacaoFisica.getDesvioPostural().getOmbro_escapula_lateral().equals("ACENTUADO") ? 14 : 0;
		
		cabeca_pesco += auxAvaliacaoFisica.getDesvioPostural().getPeitoral_lateral() != null 
				&& auxAvaliacaoFisica.getDesvioPostural().getPeitoral_lateral().equals("LIGEIRO") ? 8 : 
					auxAvaliacaoFisica.getDesvioPostural().getPeitoral_lateral() != null 
					&& auxAvaliacaoFisica.getDesvioPostural().getPeitoral_lateral().equals("ACENTUADO") ? 14 : 0;
		
	
		coluna_dorso_lombar += auxAvaliacaoFisica.getDesvioPostural().getColuna_dorsal() != null 
				&& auxAvaliacaoFisica.getDesvioPostural().getColuna_dorsal().equals("LIGEIRO") ? 14 : 
					auxAvaliacaoFisica.getDesvioPostural().getColuna_dorsal() != null 
					&& auxAvaliacaoFisica.getDesvioPostural().getColuna_dorsal().equals("ACENTUADO") ? 24 : 0;
		
		coluna_dorso_lombar += auxAvaliacaoFisica.getDesvioPostural().getCifose_lateral() != null 
				&& auxAvaliacaoFisica.getDesvioPostural().getCifose_lateral().equals("LIGEIRO") ? 14 : 
					auxAvaliacaoFisica.getDesvioPostural().getCifose_lateral() != null 
					&& auxAvaliacaoFisica.getDesvioPostural().getCifose_lateral().equals("ACENTUADO") ? 24 : 0;
		
		coluna_dorso_lombar += auxAvaliacaoFisica.getDesvioPostural().getLordose_lateral() != null 
				&& auxAvaliacaoFisica.getDesvioPostural().getLordose_lateral().equals("LIGEIRO") ? 14 : 
					auxAvaliacaoFisica.getDesvioPostural().getLordose_lateral() != null 
					&& auxAvaliacaoFisica.getDesvioPostural().getLordose_lateral().equals("ACENTUADO") ? 24 : 0;
		
		abdome_quadril += auxAvaliacaoFisica.getDesvioPostural().getAbdome_lateral()!= null 
				&& auxAvaliacaoFisica.getDesvioPostural().getAbdome_lateral().equals("LIGEIRO") ? 14 : 
					auxAvaliacaoFisica.getDesvioPostural().getAbdome_lateral() != null 
					&& auxAvaliacaoFisica.getDesvioPostural().getAbdome_lateral().equals("ACENTUADO") ? 24 : 0;
		
		abdome_quadril += auxAvaliacaoFisica.getDesvioPostural().getTronco_lateral()!= null 
				&& auxAvaliacaoFisica.getDesvioPostural().getTronco_lateral().equals("LIGEIRO") ? 14 : 
					auxAvaliacaoFisica.getDesvioPostural().getTronco_lateral() != null 
					&& auxAvaliacaoFisica.getDesvioPostural().getTronco_lateral().equals("ACENTUADO") ? 24 : 0;
		
		abdome_quadril += auxAvaliacaoFisica.getDesvioPostural().getQuadril_dorsal()!= null 
				&& auxAvaliacaoFisica.getDesvioPostural().getQuadril_dorsal().equals("LIGEIRO") ? 14 : 
					auxAvaliacaoFisica.getDesvioPostural().getQuadril_dorsal() != null 
					&& auxAvaliacaoFisica.getDesvioPostural().getQuadril_dorsal().equals("ACENTUADO") ? 24 : 0;
		
		membros_inferiores += auxAvaliacaoFisica.getDesvioPostural().getJoelho_dorsal() != null 
				&& auxAvaliacaoFisica.getDesvioPostural().getJoelho_dorsal().equals("LIGEIRO") ? 10 : 
					auxAvaliacaoFisica.getDesvioPostural().getJoelho_dorsal() != null 
					&& auxAvaliacaoFisica.getDesvioPostural().getJoelho_dorsal().equals("ACENTUADO") ? 20 : 0;
		
		membros_inferiores += auxAvaliacaoFisica.getDesvioPostural().getJoelho_lateral() != null 
				&& auxAvaliacaoFisica.getDesvioPostural().getJoelho_lateral().equals("LIGEIRO") ? 10 : 
					auxAvaliacaoFisica.getDesvioPostural().getJoelho_lateral() != null 
					&& auxAvaliacaoFisica.getDesvioPostural().getJoelho_lateral().equals("ACENTUADO") ? 20 : 0;
		
		membros_inferiores += auxAvaliacaoFisica.getDesvioPostural().getCalcanhar_dorsal() != null 
				&& auxAvaliacaoFisica.getDesvioPostural().getCalcanhar_dorsal().equals("LIGEIRO") ? 10 : 
					auxAvaliacaoFisica.getDesvioPostural().getCalcanhar_dorsal() != null 
					&& auxAvaliacaoFisica.getDesvioPostural().getCalcanhar_dorsal().equals("ACENTUADO") ? 20 : 0;
		
		membros_inferiores += auxAvaliacaoFisica.getDesvioPostural().getPe_dorsal() != null 
				&& auxAvaliacaoFisica.getDesvioPostural().getPe_dorsal().equals("LIGEIRO") ? 10 : 
					auxAvaliacaoFisica.getDesvioPostural().getPe_dorsal() != null 
					&& auxAvaliacaoFisica.getDesvioPostural().getPe_dorsal().equals("ACENTUADO") ? 20 : 0;
		
		if(cabeca_pesco > 0){
			indice += (cabeca_pesco / 8) * 2.75D;
		}
		if(coluna_dorso_lombar > 0){
			indice += (coluna_dorso_lombar / 14) * 2.75D;
		}
		if(abdome_quadril > 0){
			indice += (abdome_quadril / 14) * 2.75D;
		}
		if(membros_inferiores > 0){
			indice += (membros_inferiores / 10) * 2.75D;
		}
		
		BarChartModel model = new BarChartModel();
		 
        ChartSeries chCabeca_pescoco = new ChartSeries();
        chCabeca_pescoco.setLabel("Cabeça / Pescoço");
        chCabeca_pescoco.set("", 100 - cabeca_pesco);
 
        ChartSeries chColuna_dorso = new ChartSeries();
        chColuna_dorso.setLabel("Coluna / Dorso / Lombar");
        chColuna_dorso.set("", 100 - coluna_dorso_lombar);
        
        ChartSeries chAbdome = new ChartSeries();
        chAbdome.setLabel("Abdome / Quadril");
        chAbdome.set("", 100 - abdome_quadril);
        
        ChartSeries chMembros_inferiores = new ChartSeries();
        chMembros_inferiores.setLabel("Membros Inferiores");
        chMembros_inferiores.set("", 100 - membros_inferiores);
        
        ChartSeries chIndice = new ChartSeries();
        chIndice.setLabel("Índice Correção Postural");
        chIndice.set("", 100 - indice);
        
        ChartSeries chEmpty = new ChartSeries();
        chEmpty.setLabel(" ");
        chEmpty.set("", 0);
        
        ChartSeries chEmpty2 = new ChartSeries();
        chEmpty2.setLabel(" ");
        chEmpty2.set("", 0);
 
        model.addSeries(chCabeca_pescoco);
        model.addSeries(chColuna_dorso);
        model.addSeries(chAbdome);
        model.addSeries(chMembros_inferiores);
        model.addSeries(chIndice);
        model.addSeries(chEmpty);
        model.addSeries(chEmpty2);
        return model;
	}
	
	
	public boolean getPescocoDorsalBool(String value){
		if(value.equals(auxAvaliacaoFisica.getDesvioPostural().getPescoco_dorsal()))
			return true;
		return false;
	}
	
	public boolean getOmbroDorsalBool(String value){
		if(value.equals(auxAvaliacaoFisica.getDesvioPostural().getOmbro_dorsal()))
			return true;
		return false;
	}
	
	public boolean getColunaDorsalBool(String value){
		if(value.equals(auxAvaliacaoFisica.getDesvioPostural().getColuna_dorsal()))
			return true;
		return false;
	}
	
	public boolean getQuadrilDorsalBool(String value){
		if(value.equals(auxAvaliacaoFisica.getDesvioPostural().getQuadril_dorsal()))
			return true;
		return false;
	}
	
	public boolean getJoelhoDorsalBool(String value){
		if(value.equals(auxAvaliacaoFisica.getDesvioPostural().getJoelho_dorsal()))
			return true;
		return false;
	}
	
	public boolean getCalcanharDorsalBool(String value){
		if(value.equals(auxAvaliacaoFisica.getDesvioPostural().getCalcanhar_dorsal()))
			return true;
		return false;
	}
	
	public boolean getPeDorsalBool(String value){
		if(value.equals(auxAvaliacaoFisica.getDesvioPostural().getPe_dorsal()))
			return true;
		return false;
	}

	public boolean getPescocoLateralBool(String value){
		if(value.equals(auxAvaliacaoFisica.getDesvioPostural().getPescoco_lateral()))
			return true;
		return false;
	}
	
	public boolean getPeitoralLateralBool(String value){
		if(value.equals(auxAvaliacaoFisica.getDesvioPostural().getPeitoral_lateral()))
			return true;
		return false;
	}
	
	public boolean getOmbroEscapulaLateralBool(String value){
		if(value.equals(auxAvaliacaoFisica.getDesvioPostural().getOmbro_escapula_lateral()))
			return true;
		return false;
	}
	
	public boolean getCifoseLateralBool(String value){
		if(value.equals(auxAvaliacaoFisica.getDesvioPostural().getCifose_lateral()))
			return true;
		return false;
	}
	
	public boolean getLordoseLateralBool(String value){
		if(value.equals(auxAvaliacaoFisica.getDesvioPostural().getLordose_lateral()))
			return true;
		return false;
	}
	
	public boolean getTroncoLateralBool(String value){
		if(value.equals(auxAvaliacaoFisica.getDesvioPostural().getTronco_lateral()))
			return true;
		return false;
	}
	
	public boolean getAbdomeLateralBool(String value){
		if(value.equals(auxAvaliacaoFisica.getDesvioPostural().getAbdome_lateral()))
			return true;
		return false;
	}
	
	public boolean getJoelhoLateralBool(String value){
		if(value.equals(auxAvaliacaoFisica.getDesvioPostural().getJoelho_lateral()))
			return true;
		return false;
	}
	
	public String createFolderIfNotExists(){
		String pathFolder = Constantes.UPLOAD_IMAGES_ALUNOS_AVALIACAO + File.separator + academia.getIdAcademia() + File.separator;
		Path parentDir = new File(pathFolder).toPath();
		if (!Files.exists(parentDir)) {
			try {
				Files.createDirectories(parentDir);
			} catch (IOException e) {
				e.printStackTrace();
			}
		}		
		return pathFolder;
	}
	
	public void uploadImagemFrente(FileUploadEvent event) {
		try {
			data = event.getFile().getContents();
			String pathFolder = createFolderIfNotExists();
			
			//RemoveImagem
			if (auxAvaliacaoFisica.getDesvioPostural().getImagepath_1() != null) {
				String command = "rm " + pathFolder + auxAvaliacaoFisica.getDesvioPostural().getImagepath_1();
				Runtime.getRuntime().exec(command);
			}

			String contentType = event.getFile().getContentType();
			// Verifica o tipo do arquivo
			contentType = event.getFile().getContentType().substring(contentType.indexOf("/") + 1,contentType.length());
			String submitName = UtilPath.resolveSubmitImageName(event.getFile().getFileName());
			String fileName = pathFolder + submitName + UtilPath.getRandomImageName() + "." + contentType;
			final Path destination = new File(fileName).toPath();

			InputStream bytes = null;
			if (null != data) {
				bytes = event.getFile().getInputstream();
				Files.copy(bytes, destination);// Copies bytes to destination.
			}

			String[] texto = fileName.split(File.separator);
			String nomeArquivo = texto[texto.length - 1];
			auxAvaliacaoFisica.getDesvioPostural().setImagepath_1(nomeArquivo);
			fotoFrente = Constantes.URL_IMG_ALUNOS_AVALIACAO + academia.getIdAcademia() + "/" + nomeArquivo;
		} catch (IOException e) {
			e.printStackTrace();
			throw new FacesException("Error in writing captured image.", e);
		}
	}

	public void uploadImagemLado(FileUploadEvent event) {
		try {
			data = event.getFile().getContents();
			String pathFolder = createFolderIfNotExists();

			//RemoveImagem
			if (auxAvaliacaoFisica.getDesvioPostural().getImagepath_2() != null) {
				String command = "rm " + pathFolder + auxAvaliacaoFisica.getDesvioPostural().getImagepath_2();
				Runtime.getRuntime().exec(command);
			}

			String contentType = event.getFile().getContentType();
			// Verifica o tipo do arquivo
			contentType = event.getFile().getContentType().substring(contentType.indexOf("/") + 1,contentType.length());
			String submitName = UtilPath.resolveSubmitImageName(event.getFile().getFileName());
			String fileName = pathFolder + submitName + UtilPath.getRandomImageName() + "." + contentType;
			final Path destination = new File(fileName).toPath();

			InputStream bytes = null;
			if (null != data) {
				bytes = event.getFile().getInputstream();
				Files.copy(bytes, destination);// Copies bytes to destination.
			}

			String[] texto = fileName.split(File.separator);
			String nomeArquivo = texto[texto.length - 1];
			auxAvaliacaoFisica.getDesvioPostural().setImagepath_2(nomeArquivo);
			fotoLado = Constantes.URL_IMG_ALUNOS_AVALIACAO + academia.getIdAcademia() + "/" + nomeArquivo;
		} catch (IOException e) {
			e.printStackTrace();
			throw new FacesException("Error in writing captured image.", e);
		}
	}
	
	public void uploadImagemCostas(FileUploadEvent event) {
		try {
			data = event.getFile().getContents();
			String pathFolder = createFolderIfNotExists();

			//RemoveImagem
			if (auxAvaliacaoFisica.getDesvioPostural().getImagepath_3() != null) {
				String command = "rm " + pathFolder + + academia.getIdAcademia() + auxAvaliacaoFisica.getDesvioPostural().getImagepath_3();
				Runtime.getRuntime().exec(command);
			}

			String contentType = event.getFile().getContentType();
			// Verifica o tipo do arquivo
			contentType = event.getFile().getContentType().substring(contentType.indexOf("/") + 1,contentType.length());
			String submitName = UtilPath.resolveSubmitImageName(event.getFile().getFileName());
			String fileName = pathFolder + submitName + UtilPath.getRandomImageName() + "." + contentType;
			final Path destination = new File(fileName).toPath();

			InputStream bytes = null;
			if (null != data) {
				bytes = event.getFile().getInputstream();
				Files.copy(bytes, destination);// Copies bytes to destination.
			}

			String[] texto = fileName.split(File.separator);
			String nomeArquivo = texto[texto.length - 1];
			auxAvaliacaoFisica.getDesvioPostural().setImagepath_3(nomeArquivo);
			fotoCostas = Constantes.URL_IMG_ALUNOS_AVALIACAO + academia.getIdAcademia() + "/" + nomeArquivo;
		} catch (IOException e) {
			e.printStackTrace();
			throw new FacesException("Error in writing captured image.", e);
		}
	}
	
	public AvaliacaoFisica getAvaliacaoFisica() {
		return avaliacaoFisica;
	}

	public void setAvaliacaoFisica(AvaliacaoFisica avaliacaoFisica) {
		this.avaliacaoFisica = avaliacaoFisica;
	}

	public ArrayList<AvaliacaoFisica> getAvaliacoesFisicas() {
		return avaliacoesFisicas;
	}

	public void setAvaliacoesFisicas(
			ArrayList<AvaliacaoFisica> avaliacoesFisicas) {
		this.avaliacoesFisicas = avaliacoesFisicas;
	}

	public ArrayList<AvaliacaoFisica> getAvaliacoesFisicasFilter() {
		return avaliacoesFisicasFilter;
	}

	public void setAvaliacoesFisicasFilter(
			ArrayList<AvaliacaoFisica> avaliacoesFisicasFilter) {
		this.avaliacoesFisicasFilter = avaliacoesFisicasFilter;
	}
	
	public Aluno getAluno() {
		return aluno;
	}

	public void setAluno(Aluno aluno) {
		this.aluno = aluno;
	}

	public ArrayList<Aluno> getAlunos() {
		return alunos;
	}

	public void setAlunos(ArrayList<Aluno> alunos) {
		this.alunos = alunos;
	}

	public ArrayList<Aluno> getAlunosFilter() {
		return alunosFilter;
	}

	public void setAlunosFilter(ArrayList<Aluno> alunosFilter) {
		this.alunosFilter = alunosFilter;
	}
	

	public boolean isBtnNovoVisibility() {
		return btnNovoVisibility;
	}

	public void setBtnNovoVisibility(boolean btnNovoVisibility) {
		this.btnNovoVisibility = btnNovoVisibility;
	}

	public Date getFiltroDe() {
		return filtroDe;
	}

	public void setFiltroDe(Date filtroDe) {
		this.filtroDe = filtroDe;
	}

	public Date getFiltroAte() {
		return filtroAte;
	}

	public void setFiltroAte(Date filtroAte) {
		this.filtroAte = filtroAte;
	}
	
	public AvaliacaoFisica getAuxAvaliacaoFisica() {
		return auxAvaliacaoFisica;
	}

	public void setAuxAvaliacaoFisica(AvaliacaoFisica auxAvaliacaoFisica) {
		this.auxAvaliacaoFisica = auxAvaliacaoFisica;
	}

	public int getOptionReport() {
		return optionReport;
	}

	public void setOptionReport(int optionReport) {
		this.optionReport = optionReport;
	}

	public boolean isLinha1() {
		return linha1;
	}

	public void setLinha1(boolean linha1) {
		this.linha1 = linha1;
	}

	public boolean isLinha2() {
		return linha2;
	}

	public void setLinha2(boolean linha2) {
		this.linha2 = linha2;
	}

	public boolean isLinha3() {
		return linha3;
	}

	public void setLinha3(boolean linha3) {
		this.linha3 = linha3;
	}

	public boolean isLinha4() {
		return linha4;
	}

	public void setLinha4(boolean linha4) {
		this.linha4 = linha4;
	}

	public boolean isLinha5() {
		return linha5;
	}

	public void setLinha5(boolean linha5) {
		this.linha5 = linha5;
	}

	public boolean isLinha6() {
		return linha6;
	}

	public void setLinha6(boolean linha6) {
		this.linha6 = linha6;
	}

	public boolean isLinha7() {
		return linha7;
	}

	public void setLinha7(boolean linha7) {
		this.linha7 = linha7;
	}

	public boolean isLinha8() {
		return linha8;
	}

	public void setLinha8(boolean linha8) {
		this.linha8 = linha8;
	}

	public boolean isLinha9() {
		return linha9;
	}

	public void setLinha9(boolean linha9) {
		this.linha9 = linha9;
	}

	public boolean isLinha10() {
		return linha10;
	}

	public void setLinha10(boolean linha10) {
		this.linha10 = linha10;
	}

	public BarChartModel getBarModel() {
		return barModel;
	}

	public void setBarModel(BarChartModel barModel) {
		this.barModel = barModel;
	}

	public String getFotoFrente() {
		return fotoFrente;
	}

	public void setFotoFrente(String fotoFrente) {
		this.fotoFrente = fotoFrente;
	}

	public String getFotoLado() {
		return fotoLado;
	}

	public void setFotoLado(String fotoLado) {
		this.fotoLado = fotoLado;
	}

	public String getFotoCostas() {
		return fotoCostas;
	}

	public void setFotoCostas(String fotoCostas) {
		this.fotoCostas = fotoCostas;
	}

	public String getImagesPathAvaliacao() {
		return imagesPathAvaliacao;
	}

	public void setImagesPathAvaliacao(String imagesPathAvaliacao) {
		this.imagesPathAvaliacao = imagesPathAvaliacao;
	}

	public Bioimpedancia getBioimpedancia() {
		return bioimpedancia;
	}

	public void setBioimpedancia(Bioimpedancia bioimpedancia) {
		System.out.println("Chamou o biooooo");
		if(bioimpedancia == null) {
			bioimpedancia = new Bioimpedancia();
		} else {
		this.bioimpedancia = bioimpedancia;
		}
	}

	public Bioimpedancia getBioimpedanciaAux() {
		return bioimpedanciaAux;
	}

	public void setBioimpedanciaAux(Bioimpedancia bioimpedanciaAux) {
		this.bioimpedanciaAux = bioimpedanciaAux;
	}
	
	public void settarGordura() {
		this.bioimpedancia.setGordura(bioimpedancia.getGordura());
	}

	public String getNomeAluno() {
		return nomeAluno;
	}

	public void setNomeAluno(String nomeAluno) {
		this.nomeAluno = nomeAluno;
	}
	
	public void imprimirBioimpedancia(Integer bio) {
		RequestContext context = RequestContext.getCurrentInstance();
		String image_path = AutenticacaoMB.loadImageAcademia(academia);
		String caminhoReport = "";
		try {
			caminhoReport = Faces.getRealPath("/reports/avaliacao/avaliacao_bioimpedancia.jasper");	
			context.execute("window.open('" +Faces.getRequestContextPath()
					+ "/pages/pdf.xhtml?faces-redirect=true"
					+ "&jrxml=" + URLEncoder.encode(caminhoReport, "UTF-8") + ""
					+ "&idAcademia="+academia.getIdAcademia()
					+ "&idBio="+bio
				    + "&caminhoimagem="+URLEncoder.encode(image_path, "UTF-8")+"')");

	}catch(Exception e){
		e.printStackTrace();
	}
 }

	public void calcularAltura() {
		this.auxAvaliacaoFisica.setAltura(this.auxAvaliacaoFisica.getAltura());
		String alturaConvertida = String.valueOf(this.auxAvaliacaoFisica.getAltura());
		System.out.println("Tamanho : " + alturaConvertida.length() + "/" + alturaConvertida);
		if(alturaConvertida.length() > 4) {
			JSFUtil.addMensagensErro("Campo com numeros invalidos");
			this.auxAvaliacaoFisica.setAltura(0);
		}
	}
	
	public void resultadoGorduraCorporal() {
		this.bioimpedancia.setGordura(this.bioimpedancia.getGordura());
		System.out.println("Gordura : " + bioimpedancia.getGordura());
		System.out.println("Idade : " + bioimpedancia.getIdade() + "/" + bioimpedancia.getSexo());
	}
	
	public void settarIdade() {
		this.bioimpedancia.setIdade(this.bioimpedancia.getIdade());
	}
	
	public void settarSexo() {
		this.bioimpedancia.setSexo(this.bioimpedancia.getSexo());
	}
	
	public void verificarImc() {
		this.bioimpedancia.setPesoAtual(this.bioimpedancia.getPesoAtual());
		this.bioimpedancia.setAltura(this.bioimpedancia.getAltura());
		
		System.out.println(bioimpedancia.getPesoAtual());
		System.out.println(bioimpedancia.getAltura());
		
		Double resultadoImc = this.bioimpedancia.getPesoAtual() / (this.bioimpedancia.getAltura() * this.bioimpedancia.getAltura());
		
		this.bioimpedancia.setImc(resultadoImc);
		System.out.println(resultadoImc);
	}
	
	public void settarIdadeCorporal() {
		if(this.bioimpedancia.getIdadeCorporal() < this.bioimpedancia.getIdade()) {
			System.out.println("Menor");
			this.bioimpedancia.setResultadoIdadeCorporal(this.bioimpedancia.getIdadeCorporal() - this.bioimpedancia.getIdade() + " anos(s)");
			return;
		} 
		if(this.bioimpedancia.getIdadeCorporal() > this.bioimpedancia.getIdade()) {
			System.out.println("Maior");
			this.bioimpedancia.setResultadoIdadeCorporal(" + " + (this.bioimpedancia.getIdadeCorporal() - this.bioimpedancia.getIdade()) + " anos(s)");
			return;
		}
		if(this.bioimpedancia.getIdadeCorporal() == this.bioimpedancia.getIdade()) {
			System.out.println("Igual");
			this.bioimpedancia.setResultadoIdadeCorporal(this.bioimpedancia.getIdadeCorporal() - this.bioimpedancia.getIdade() + "  anos(s)");
		}
	}	
	
	public void verificarPorcentualGordura() {
		if(bioimpedancia.getSexo().equals("M")) {
			if(bioimpedancia.getIdade() >= 20 && bioimpedancia.getIdade() <= 29) {
				if(bioimpedancia.getGordura() <= 5.2) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 5.2 && bioimpedancia.getGordura() <= 9.3) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 9.3 && bioimpedancia.getGordura() <= 14.1) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 14.1 && bioimpedancia.getGordura() <= 17.5) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 17.5 && bioimpedancia.getGordura() <= 22.4) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 22.4 && bioimpedancia.getGordura() <= 29.2) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 29.2) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso II");
					return;
				}
			}
			
			if(bioimpedancia.getIdade() > 29 && bioimpedancia.getIdade() <= 39) {
				if(bioimpedancia.getGordura() <= 9.2) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 9.2 && bioimpedancia.getGordura() <= 14.0) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 14.0 && bioimpedancia.getGordura() <= 17.5) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 17.5 && bioimpedancia.getGordura() <= 20.6) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 20.6 && bioimpedancia.getGordura() <= 24.2) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 24.2 && bioimpedancia.getGordura() <= 30.0) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 30.0) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso II");
					return;
				}
			}
			
			if(bioimpedancia.getIdade() > 39 && bioimpedancia.getIdade() <= 49) {
				if(bioimpedancia.getGordura() <= 11.5) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 11.5 && bioimpedancia.getGordura() <= 16.3) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 16.3 && bioimpedancia.getGordura() <= 19.6) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 19.6 && bioimpedancia.getGordura() <= 22.5) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 22.5 && bioimpedancia.getGordura() <= 26.2) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 26.2 && bioimpedancia.getGordura() <= 31.4) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 31.4) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso II");
					return;
				}
			}
			
			if(bioimpedancia.getIdade() > 49 && bioimpedancia.getIdade() <= 59) {
				if(bioimpedancia.getGordura() <= 12.9) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 12.9 && bioimpedancia.getGordura() <= 18.1) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 18.1 && bioimpedancia.getGordura() <= 21.2) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 21.2 && bioimpedancia.getGordura() <= 24.2) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 24.2 && bioimpedancia.getGordura() <= 27.6) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 27.6 && bioimpedancia.getGordura() <= 32.4) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 32.4) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso II");
					return;
				}
			}
			
			if(bioimpedancia.getIdade() > 59) {
				if(bioimpedancia.getGordura() <= 13.0) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 13.0 && bioimpedancia.getGordura() <= 18.5) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 18.6 && bioimpedancia.getGordura() <= 22.0) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 22.0 && bioimpedancia.getGordura() <= 25.0) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 25.0 && bioimpedancia.getGordura() <= 28.4) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 28.4 && bioimpedancia.getGordura() <= 33.5) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 33.5) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso II");
					return;
				}
			}
			
		} else {
			
			if(bioimpedancia.getIdade() >= 20 && bioimpedancia.getIdade() <= 29) {
				if(bioimpedancia.getGordura() <= 10.7) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 10.7 && bioimpedancia.getGordura() <= 17.0) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 17.0 && bioimpedancia.getGordura() <= 20.5) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 20.5 && bioimpedancia.getGordura() <= 23.8) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 23.8 && bioimpedancia.getGordura() <= 27.6) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 27.6 && bioimpedancia.getGordura() <= 35.5) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 35.5) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso II");
					return;
				}
			}
			
			if(bioimpedancia.getIdade() > 29 && bioimpedancia.getIdade() <= 39) {
				if(bioimpedancia.getGordura() <= 13.3) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 13.3 && bioimpedancia.getGordura() <= 18.0) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 18.0 && bioimpedancia.getGordura() <= 21.8) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 21.8 && bioimpedancia.getGordura() <= 24.8) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 24.8 && bioimpedancia.getGordura() <= 30.0) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 30.0 && bioimpedancia.getGordura() <= 35.8) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 35.8) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso II");
					return;
				}
			}
			
			if(bioimpedancia.getIdade() > 39 && bioimpedancia.getIdade() <= 49) {
				if(bioimpedancia.getGordura() <= 16.1) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 16.1 && bioimpedancia.getGordura() <= 21.4) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 21.4 && bioimpedancia.getGordura() <= 25.1) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 25.1 && bioimpedancia.getGordura() <= 28.3) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 28.3 && bioimpedancia.getGordura() <= 32.1) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 32.1 && bioimpedancia.getGordura() <= 37.7) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 37.7) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso II");
					return;
				}
			}
			
			if(bioimpedancia.getIdade() > 49 && bioimpedancia.getIdade() <= 59) {
				if(bioimpedancia.getGordura() <= 18.8) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 18.8 && bioimpedancia.getGordura() <= 25.1) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 25.1 && bioimpedancia.getGordura() <= 28.6) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 28.6 && bioimpedancia.getGordura() <= 32.5) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 32.5 && bioimpedancia.getGordura() <= 35.6) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 35.6 && bioimpedancia.getGordura() <= 39.6) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 39.6) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso II");
					return;
				}
			}
			
			if(bioimpedancia.getIdade() > 59) {
				if(bioimpedancia.getGordura() <= 19.1) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 19.1 && bioimpedancia.getGordura() <= 25.0) {
					bioimpedancia.setResultadoGorduraCorporal("Abaixo do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 25.0 && bioimpedancia.getGordura() <= 29.5) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 29.5 && bioimpedancia.getGordura() <= 32.8) {
					bioimpedancia.setResultadoGorduraCorporal("Normal");
					return;
				}
				if(bioimpedancia.getGordura() > 32.8 && bioimpedancia.getGordura() <= 36.7) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso");
					return;
				}
				if(bioimpedancia.getGordura() > 36.7 && bioimpedancia.getGordura() <= 40.4) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso I");
					return;
				}
				if(bioimpedancia.getGordura() > 40.4) {
					bioimpedancia.setResultadoGorduraCorporal("Acima do peso II");
					return;
				}
			}
		}
	}
	
	public void calcularMetabolismoBasal() {
			if(bioimpedancia.getMetabolismoBasal() < 1200) {
				this.bioimpedancia.setResultadoMetabolismoBasal("Sedentária");
				return;
			}
			
			if(bioimpedancia.getMetabolismoBasal() >= 1200 && bioimpedancia.getMetabolismoBasal() <= 1375) {
				this.bioimpedancia.setResultadoMetabolismoBasal("Sedentária");
				return;
			}
			
			if(bioimpedancia.getMetabolismoBasal() > 1375 && bioimpedancia.getMetabolismoBasal() <= 1555) {
				this.bioimpedancia.setResultadoMetabolismoBasal("Atividade Leve");
				return;
			}
			
			if(bioimpedancia.getMetabolismoBasal() > 1555 && bioimpedancia.getMetabolismoBasal() <= 1725) {
				this.bioimpedancia.setResultadoMetabolismoBasal("Atividade Alta");
				return;
			}
			
			if(bioimpedancia.getMetabolismoBasal() > 1725) {
				this.bioimpedancia.setResultadoMetabolismoBasal("Atividade Muito Alta");
				return;
			}
	}
	
	public void calcularPesoIdeal() {
		
		String alturaConvertida = bioimpedancia.getAltura().toString();
		String replace = alturaConvertida.replace(".", "");
		
		if(bioimpedancia.getSexo().equals("M")) {
				Double pesoIdeal = 0.75 * Double.valueOf(replace) - 62.5;
				bioimpedancia.setValorPesoIdeal(Math.ceil(pesoIdeal));
				String diferenca = String.valueOf(bioimpedancia.getPesoAtual() - pesoIdeal);
				boolean with = diferenca.startsWith("-");
				bioimpedancia.setValorDiferencaPeso(Math.ceil(Double.valueOf(diferenca)));
				if(with) {
					this.bioimpedancia.setResultadoPeso("Abaixo");
				} else {
					this.bioimpedancia.setResultadoPeso("Acima");
				}
		} else {
			Double pesoIdeal = 0.67 * Double.valueOf(replace) - 52;
			bioimpedancia.setValorPesoIdeal(Math.ceil(pesoIdeal));
			String diferenca = String.valueOf(bioimpedancia.getPesoAtual() - pesoIdeal);
			boolean with = diferenca.startsWith("-");
			bioimpedancia.setValorDiferencaPeso(Math.ceil(Double.valueOf(diferenca)));
				if(with) {
					this.bioimpedancia.setResultadoPeso("Abaixo");
				} else {
					this.bioimpedancia.setResultadoPeso("Acima");
				}
			}
	}
	
	public void novo() {
		
		if(aluno.getIdAluno() != 0) {
			
			RequestContext.getCurrentInstance().execute("PF('dlgNovo').show();");
				
			this.bioimpedancia.setIdade(auxAvaliacaoFisica.getIdade_atual());
			this.bioimpedancia.setPesoAtual(auxAvaliacaoFisica.getPeso_atual());
			this.bioimpedancia.setAltura(auxAvaliacaoFisica.getAltura());
			this.bioimpedancia.setImc(auxAvaliacaoFisica.getImc());
			this.bioimpedancia.setResultadoImc(auxAvaliacaoFisica.getResultado_imc());
			
			
			if(aluno.getGenero().equals("Masculino")) {
				this.bioimpedancia.setSexo("M");
			} else {
				this.bioimpedancia.setSexo("F");
			}
			
			settarResultadoQuadrilCintura();
			
			if(this.bioimpedancia.getAltura() == null || this.bioimpedancia.getAltura() == 0.0) {
				this.bioimpedancia.setAltura(this.auxAvaliacaoFisica.getAltura());
				this.bioimpedancia.setPesoAtual(this.auxAvaliacaoFisica.getPeso_atual());
				calcularPesoIdeal();
			} else {
				calcularPesoIdeal();
			}
				
			this.bioimpedancia.setGordura(0.0);
			this.bioimpedancia.setGorduraVisceral(0);
			this.bioimpedancia.setMusculoEsqueletico(0.0);
			this.bioimpedancia.setMassaMuscular(0.0);
			this.bioimpedancia.setMetabolismoBasal(0);
			this.bioimpedancia.setResultadoGorduraCorporal("");
			this.bioimpedancia.setIdadeCorporal(0);
			this.bioimpedancia.setResultadoMetabolismoBasal("");
			this.bioimpedancia.setId(null);
				
		} else {
			JSFUtil.addMensagensErro("Selecione um aluno");
		}
	}
	
	public void settarCinturaAvaliacao() {
		this.auxAvaliacaoFisica.getPerimetro().setCintura(this.auxAvaliacaoFisica.getPerimetro().getCintura());
	}
	
	public void settarRelacaoCintura() {
		System.out.println(auxAvaliacaoFisica.getAluno().getGenero());
		System.out.println(auxAvaliacaoFisica.getIdade_atual());
		
		this.auxAvaliacaoFisica.getPerimetro().setQuadril(this.auxAvaliacaoFisica.getPerimetro().getQuadril());
		
		System.out.println(this.auxAvaliacaoFisica.getPerimetro().getCintura());
		System.out.println(this.auxAvaliacaoFisica.getPerimetro().getQuadril());
		
		this.auxAvaliacaoFisica.setValorCinturaQuadril(this.auxAvaliacaoFisica.getPerimetro().getCintura() / this.auxAvaliacaoFisica.getPerimetro().getQuadril());
		
		if(auxAvaliacaoFisica.getAluno().getGenero().equals("Masculino")) {
			if(auxAvaliacaoFisica.getIdade_atual() <= 29) {
				if(auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.83) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Baixo");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.83 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.88) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Moderado");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.88 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.94) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Alto");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.94) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Muito Alto");
					return;
				}
			}
			if(auxAvaliacaoFisica.getIdade_atual() > 29 && auxAvaliacaoFisica.getIdade_atual() <= 39) {
				if(auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.84) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Baixo");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.84 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.91) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Moderado");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.91 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.96) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Alto");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.96) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Muito Alto");
					return;
				}
			}
			if(auxAvaliacaoFisica.getIdade_atual() > 39 && auxAvaliacaoFisica.getIdade_atual() <= 49) {
				if(auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.88) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Baixo");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.88 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.95) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Moderado");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.95 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 1.00) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Alto");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 1.00) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Muito Alto");
					return;
				}
			}
			if(auxAvaliacaoFisica.getIdade_atual() > 49 && auxAvaliacaoFisica.getIdade_atual() <= 59) {
				if(auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.90) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Baixo");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.90 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.96) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Moderado");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.96 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 1.02) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Alto");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 1.02) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Muito Alto");
					return;
				}
			}
			if(auxAvaliacaoFisica.getIdade_atual() > 59) {
				if(auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.91) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Baixo");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.91 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.98) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Moderado");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.98 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 1.03) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Alto");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 1.03) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Muito Alto");
					return;
				}
			}
		} else {
			if(auxAvaliacaoFisica.getIdade_atual() <= 29 ) {
				if(auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.71) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Baixo");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.71 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.77) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Moderado");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.77 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.82) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Alto");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.82) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Muito Alto");
					return;
				}
			}
			if(auxAvaliacaoFisica.getIdade_atual() > 29 && auxAvaliacaoFisica.getIdade_atual() <= 39) {
				if(auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.72) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Baixo");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.72 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.78) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Moderado");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.78 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.84) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Alto");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.84) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Muito Alto");
					return;
				}
			}
			if(auxAvaliacaoFisica.getIdade_atual() > 39 && auxAvaliacaoFisica.getIdade_atual() <= 49) {
				if(auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.73) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Baixo");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.73 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.79) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Moderado");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.79 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.87) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Alto");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.87) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Muito Alto");
					return;
				}
			}
			if(auxAvaliacaoFisica.getIdade_atual() > 49 && auxAvaliacaoFisica.getIdade_atual() <= 59) {
				if(auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.74) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Baixo");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.74 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.81) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Moderado");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.81 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.88) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Alto");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.88) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Muito Alto");
					return;
				}
			}
			if(auxAvaliacaoFisica.getIdade_atual() > 59) {
				if(auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.76) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Baixo");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.76 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.83) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Moderado");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.83 && auxAvaliacaoFisica.getValorCinturaQuadril() <= 0.90) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Alto");
					return;
				}
				if(auxAvaliacaoFisica.getValorCinturaQuadril() > 0.90) {
					this.auxAvaliacaoFisica.setResultadoValorCinturaQuadril("Muito Alto");
					return;
				}
			}
		}
	}
	
	public void settarResultadoQuadrilCintura() {
		if(aluno.getGenero().equals("Masculino")) {
			this.bioimpedancia.setSexo("M");
		} else {
			this.bioimpedancia.setSexo("F");
		}
		this.bioimpedancia.setIdade(auxAvaliacaoFisica.getIdade_atual());
		System.out.println(bioimpedancia.getIdade());
		System.out.println("Valor cintura : " + this.bioimpedancia.getCintura());
		System.out.println("Valor quadril : " + this.bioimpedancia.getQuadril());
		this.bioimpedancia.setValorRelacaoCinturaQuadril(this.bioimpedancia.getCintura() / this.bioimpedancia.getQuadril());
		if(bioimpedancia.getSexo().equals("M")) {
			if(bioimpedancia.getIdade() <= 29) {
				if(bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.83) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Baixo");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.83 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.88) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Moderado");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.88 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.94) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Alto");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.94) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Muito Alto");
					return;
				}
			}
			if(bioimpedancia.getIdade() > 29 && bioimpedancia.getIdade() <= 39) {
				if(bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.84) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Baixo");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.84 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.91) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Moderado");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.91 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.96) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Alto");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.96) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Muito Alto");
					return;
				}
			}
			if(bioimpedancia.getIdade() > 39 && bioimpedancia.getIdade() <= 49) {
				if(bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.88) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Baixo");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.88 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.95) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Moderado");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.95 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 1.00) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Alto");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 1.00) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Muito Alto");
					return;
				}
			}
			if(bioimpedancia.getIdade() > 49 && bioimpedancia.getIdade() <= 59) {
				if(bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.90) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Baixo");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.90 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.96) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Moderado");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.96 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 1.02) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Alto");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 1.02) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Muito Alto");
					return;
				}
			}
			if(bioimpedancia.getIdade() > 59) {
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.91) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Baixo");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.91 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.98) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Moderado");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.98 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 1.03) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Alto");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 1.03) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Muito Alto");
					return;
				}
			}
			
		} else {
			if(bioimpedancia.getIdade() <= 29) {
				if(bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.71) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Baixo");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.71 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.77) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Moderado");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.77 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.82) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Alto");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.82) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Muito Alto");
					return;
				}
			}
			if(bioimpedancia.getIdade() > 29 && bioimpedancia.getIdade() <= 39) {
				if(bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.72) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Baixo");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.72 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.78) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Moderado");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.78 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.84) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Alto");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.84) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Muito Alto");
					return;
				}
			}
			if(bioimpedancia.getIdade() > 39 && bioimpedancia.getIdade() <= 49) {
				if(bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.73) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Baixo");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.73 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.79) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Moderado");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.79 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.87) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Alto");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.87) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Muito Alto");
					return;
				}
			}
			if(bioimpedancia.getIdade() > 49 && bioimpedancia.getIdade() <= 59) {
				if(bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.74) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Baixo");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.74 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.81) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Moderado");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.81 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.88) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Alto");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.88) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Muito Alto");
					return;
				}
			}
			if(bioimpedancia.getIdade() > 59) {
				if(bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.76) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Baixo");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.76 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.83) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Moderado");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.83 && bioimpedancia.getValorRelacaoCinturaQuadril() <= 0.90) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Alto");
					return;
				}
				if(bioimpedancia.getValorRelacaoCinturaQuadril() > 0.90) {
					this.bioimpedancia.setResultadoRelacaoCinturaQuadril("Muito Alto");
					return;
				}
			}
		}
	}
	
	public void settarQuadril() {
		this.bioimpedancia.setQuadril(this.bioimpedancia.getQuadril());
	}
	
	public void settarCintura() {
		this.bioimpedancia.setCintura(this.bioimpedancia.getCintura());
	}
	
	// pega a altura e converter para String, o raplace tira o . do Double
	public String converterDoubleString() {
		String valor = String.valueOf(auxAvaliacaoFisica.getAltura());
		String replace = valor.replace(".", "");	
		return replace;
	}
	
	public void settarPesoAtual() {
		this.bioimpedancia.setPesoAtual(this.bioimpedancia.getPesoAtual());
	}
	
	public void verificarResultadoImc() {
			if (this.bioimpedancia.getImc() <= 17)  {
				this.bioimpedancia.setResultadoImc("Muito abaixo do peso");
			} else if (this.bioimpedancia.getImc() <= 18.49) {
				this.bioimpedancia.setResultadoImc("Abaixo do Peso");
			} else if (this.bioimpedancia.getImc() <= 25) {
				this.bioimpedancia.setResultadoImc("Peso ideal");
			} else if (this.bioimpedancia.getImc() <= 30) {
				this.bioimpedancia.setResultadoImc("Acima");
			} else if (this.bioimpedancia.getImc() <= 35) {
				this.bioimpedancia.setResultadoImc("Obesidade l");
			} else if (this.bioimpedancia.getImc() <= 40) {
				this.bioimpedancia.setResultadoImc("Obesidade ll");
			} else {
				this.bioimpedancia.setResultadoImc("Obesidade lll");		
			}
	}
	
	public void rendered() {
			this.setRenderizarCampo(false);
			bioimpedancia = bioimpedanciaDao.buscarPorCodigo("SELECT * FROM bioimpedancia as bio INNER JOIN aluno AS alu "
					+ "ON bio.aluno = alu.idaluno WHERE alu.academia = " + academia.getIdAcademia() + " AND bio.aluno = " + auxAvaliacaoFisica.getAluno().getIdAluno());
			
			if(auxAvaliacaoFisica.getAltura() == 0.00) {
				try {
					this.auxAvaliacaoFisica.setAltura(bioimpedancia.getAltura());
					this.auxAvaliacaoFisica.setPeso_atual(bioimpedancia.getPesoAtual());
					this.auxAvaliacaoFisica.setImc(bioimpedancia.getImc());
					this.auxAvaliacaoFisica.setResultado_imc(bioimpedancia.getResultadoImc());
				}catch(NullPointerException e) {
					
				}
			}	
	}
	
	public void settarMusculoEsqueletico() {
		this.bioimpedancia.setMusculoEsqueletico(this.bioimpedancia.getMusculoEsqueletico());
		
		
		if(bioimpedancia.getSexo().equals("F")) {
			System.out.println("Musculo esqueletico : " + bioimpedancia.getMusculoEsqueletico());
			System.out.println("Feminino");
			
			if(bioimpedancia.getIdade() <= 18 || bioimpedancia.getIdade() <= 39) {
				if(bioimpedancia.getMusculoEsqueletico() <= 23.3) {
					System.out.println("Entre 23.3");
					bioimpedancia.setResultadoMusculoEsqueletico("Baixo");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 23.3 && bioimpedancia.getMusculoEsqueletico() <= 30.3) {
					System.out.println("Entre 23.3 e 30.3");
					bioimpedancia.setResultadoMusculoEsqueletico("Normal");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 30.3 && bioimpedancia.getMusculoEsqueletico() <= 35.3) {
					System.out.println("Entre 30.3 e 35.3");
					bioimpedancia.setResultadoMusculoEsqueletico("Alto");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 35.3) {
					System.out.println("Entre 35.3");
					bioimpedancia.setResultadoMusculoEsqueletico("Muito Alto");
					return;
				}
			}
			if(bioimpedancia.getIdade() > 39 && bioimpedancia.getIdade() <= 59) {
				if(bioimpedancia.getMusculoEsqueletico() <= 24.1) {
					bioimpedancia.setResultadoMusculoEsqueletico("Baixo");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 24.1 && bioimpedancia.getMusculoEsqueletico() <= 30.1) {
					bioimpedancia.setResultadoMusculoEsqueletico("Normal");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 30.1 && bioimpedancia.getMusculoEsqueletico() <= 35.1) {
					bioimpedancia.setResultadoMusculoEsqueletico("Alto");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 35.1) {
					bioimpedancia.setResultadoMusculoEsqueletico("Muito Alto");
					return;
				}
			}
			if(bioimpedancia.getIdade() > 59 && bioimpedancia.getIdade() <= 100) {
				if(bioimpedancia.getMusculoEsqueletico() <= 23.9) {	
					bioimpedancia.setResultadoMusculoEsqueletico("Baixo");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 23.9 && bioimpedancia.getMusculoEsqueletico() <= 29.9) {
					bioimpedancia.setResultadoMusculoEsqueletico("Normal");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 29.9 && bioimpedancia.getMusculoEsqueletico() <= 34.9) {
					bioimpedancia.setResultadoMusculoEsqueletico("Alto");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 35.0) {
					bioimpedancia.setResultadoMusculoEsqueletico("Muito Alto");
					return;
				}
			}
			
		} else {
			if(bioimpedancia.getIdade() <= 18 || bioimpedancia.getIdade() <= 39) {
				if(bioimpedancia.getMusculoEsqueletico() <= 33.3) {
					bioimpedancia.setResultadoMusculoEsqueletico("Baixo");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 33.3 && bioimpedancia.getMusculoEsqueletico() <= 39.3) {
					bioimpedancia.setResultadoMusculoEsqueletico("Normal");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 39.3 && bioimpedancia.getMusculoEsqueletico() <= 44.0) {
					bioimpedancia.setResultadoMusculoEsqueletico("Alto");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 44.0) {
					bioimpedancia.setResultadoMusculoEsqueletico("Muito Alto");
					return;
				}
			}
			
			if(bioimpedancia.getIdade() > 39 && bioimpedancia.getIdade() <= 59) {
				if(bioimpedancia.getMusculoEsqueletico() <= 33.1) {
					bioimpedancia.setResultadoMusculoEsqueletico("Baixo");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 33.1 && bioimpedancia.getMusculoEsqueletico() <= 39.1) {
					bioimpedancia.setResultadoMusculoEsqueletico("Normal");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 39.1 && bioimpedancia.getMusculoEsqueletico() <= 43.8) {
					bioimpedancia.setResultadoMusculoEsqueletico("Alto");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 43.8) {
					bioimpedancia.setResultadoMusculoEsqueletico("Muito Alto");
					return;
				}
			}
			
			if(bioimpedancia.getIdade() > 59 && bioimpedancia.getIdade() <= 100) {
				if(bioimpedancia.getMusculoEsqueletico() <= 32.9) {
					bioimpedancia.setResultadoMusculoEsqueletico("Baixo");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 32.9 && bioimpedancia.getMusculoEsqueletico() <= 38.9) {
					bioimpedancia.setResultadoMusculoEsqueletico("Normal");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 38.9 && bioimpedancia.getMusculoEsqueletico() <= 43.6) {
					bioimpedancia.setResultadoMusculoEsqueletico("Alto");
					return;
				}
				if(bioimpedancia.getMusculoEsqueletico() > 43.6) {
					bioimpedancia.setResultadoMusculoEsqueletico("Muito Alto");
					return;
				}
			}
			
		}
	}
	
	public void settarGorduraVisceral() {
		this.bioimpedancia.setGorduraVisceral(this.bioimpedancia.getGorduraVisceral());
		if(bioimpedancia.getGorduraVisceral() <= 9) {
			this.bioimpedancia.setResultadoGorduraVisceral("Normal");
			return;
		}
		
		if(bioimpedancia.getGorduraVisceral() > 9 && bioimpedancia.getGorduraVisceral() <= 14) {
			this.bioimpedancia.setResultadoGorduraVisceral("Alto");
			return;
		}
		
		if(bioimpedancia.getGorduraVisceral() > 14 ) {
			this.bioimpedancia.setResultadoGorduraVisceral("Muito Alto");
			return;
		}
		
	}
	
	public void settarListaBiopedanciaAluno() {
		String parametroBio = "SELECT * FROM bioimpedancia AS bio INNER JOIN aluno AS alu "
				+ "ON bio.aluno = alu.idaluno where alu.idaluno = " + auxAvaliacaoFisica.getAluno().getIdAluno();
		bios = bioimpedanciaDao.listar(parametroBio);
	}
	
	public String excluirAvaliacao(AvaliacaoFisica avaliacao) {
		try {
			this.avaliacaoFisicaDAO.excluir(avaliacao.getIdavaliacao_fisica());
			JSFUtil.addMensagensSucesso("Avaliação excluida com sucesso");	
			System.out.println(avaliacoesFisicas.size());
			avaliacoesFisicas = avaliacaoFisicaDAO.consultar(sql  + aluno.getIdAluno() + " ORDER BY avaliacao.numero_avaliacao");
			System.out.println(avaliacoesFisicas.size());
			Ajax.update("frmAvaliacao:tabView:tblAvaliacoes");
			return "/pages/avaliacao/avaliacao.xhtml?faces-redirect=true";
		} catch (Exception e) {
			e.printStackTrace();
			return "";
		}
	}
	
	public void zerarCampos() {
		bioimpedancia = new Bioimpedancia();
	}
	
	public void calucularPesoAtual() {
		this.bioimpedancia.setPesoAtual(this.auxAvaliacaoFisica.getPeso_atual());
	}
	
	public void calcularAlturaAtual() {
		this.bioimpedancia.setAltura(this.auxAvaliacaoFisica.getAltura());
	}
	
	public void settarQuilosMinimo() {
		
		System.out.println("AUX avaliacao fisica: " + auxAvaliacaoFisica.getResultado_gordura_ideal_minimo());
		auxAvaliacaoFisica.setResultado_gordura_ideal_minimo(this.auxAvaliacaoFisica.getResultado_gordura_ideal_minimo());
		
		//System.out.println("Avaliação fisica : " + avaliacaoFisica.getResultado_gordura_ideal_minimo());
		
		System.out.println("Resultado gordura idael minimo : " + auxAvaliacaoFisica.getResultado_gordura_ideal_minimo());
		System.out.println("Peso atual : " + auxAvaliacaoFisica.getPeso_atual());
		
		Double resultado = (this.auxAvaliacaoFisica.getPeso_atual() * this.auxAvaliacaoFisica.getResultado_gordura_ideal_minimo()) / 100;
		this.auxAvaliacaoFisica.setResultadoPesoGorduraIdeal(resultado);
		
		
		if(aluno.getGenero() != null){
			int genero = aluno.getGenero().equals("Masculino") ? 1 : 2;
			
			System.out.println("GENERO : " + genero);
			
			int gordural_ideal = genero == 1 ? 15 : 25;
			
			System.out.println("Gordura ideal : " + gordural_ideal);
			
			double diferencaPesoIdeal = NutricaoUtil.calculaDiferencaPesoIdeal(gordural_ideal, auxAvaliacaoFisica.getResultado_gordura_ideal_minimo());
			
			System.out.println("Gordura ideal minimo : " + auxAvaliacaoFisica.getResultado_gordura_ideal_minimo());
			
			System.out.println("Diferença entre peso ideal : " + diferencaPesoIdeal);
			
			double diferencaKG = NutricaoUtil.calculaKgPesoIdealSobrePeso(auxAvaliacaoFisica.getPeso_atual(), diferencaPesoIdeal);
			
			System.out.println("Diferença entre KG : " + diferencaKG);
			
			
			
			//ADICIONADO MARGEM DE ERRO PARA 1
			if(auxAvaliacaoFisica.getResultado_gordura_atual() > gordural_ideal){
				
				System.out.println("Entrou no if");
				
				this.auxAvaliacaoFisica.setResultado_peso_ideal(auxAvaliacaoFisica.getPeso_atual() - diferencaKG + 1);
				
				System.out.println("Resultado peso ideal : " + this.auxAvaliacaoFisica.getResultado_peso_ideal());
			
			}else{
				
				System.out.println("Entrou no if");
				
				this.auxAvaliacaoFisica.setResultado_peso_ideal(auxAvaliacaoFisica.getPeso_atual() + diferencaKG + 1);
				
				System.out.println("Resultado peso ideal : " + this.auxAvaliacaoFisica.getResultado_peso_ideal());
			}
		}	
	}
	
	public void settarQuilosGorduraAtual() {
		this.auxAvaliacaoFisica.setResultado_gordura_atual(auxAvaliacaoFisica.getResultado_gordura_atual());
		System.out.println(this.auxAvaliacaoFisica.getResultado_gordura_ideal_minimo() + " Gordura Atual");
		System.out.println("Peso atual : " + this.auxAvaliacaoFisica.getResultado_gordura_atual());
		Double resultado = (this.auxAvaliacaoFisica.getPeso_atual() * this.auxAvaliacaoFisica.getResultado_gordura_atual()) / 100;
		this.auxAvaliacaoFisica.setResultadoPesoGorduraAtual(resultado);
		this.auxAvaliacaoFisica.setResultadoPesoGorduraAtual(resultado);
		this.auxAvaliacaoFisica.setResultado_gordura_ideal_maximo(this.auxAvaliacaoFisica.getResultado_gordura_ideal_minimo() - this.auxAvaliacaoFisica.getResultado_gordura_atual());
		System.out.println("Resultado : " + auxAvaliacaoFisica.getResultado_gordura_ideal_maximo());
		
	}
	
	public void visualizarAvaliacao() {
		this.setBtnNovoVisibility(false);
		this.setQuantidadeAvaliacao(false);
		
		//this.avaliacaoFisica.setNumero_avaliacao(avaliacaoFisica.getNumero_avaliacao() + 1);
	}
	
	public Boolean getBotaoNovoAluno() {
		return botaoNovoAluno;
	}
	public void setBotaoNovoAluno(Boolean botaoNovoAluno) {
		this.botaoNovoAluno = botaoNovoAluno;
	}
	public List<Bioimpedancia> getBios() {
		return bios;
	}
	public void setBios(List<Bioimpedancia> bios) {
		this.bios = bios;
	}
	public Boolean getRenderizarCampo() {
		return renderizarCampo;
	}
	public void setRenderizarCampo(Boolean renderizarCampo) {
		this.renderizarCampo = renderizarCampo;
	}
	public Boolean getQuantidadeAvaliacao() {
		return quantidadeAvaliacao;
	}
	public void setQuantidadeAvaliacao(Boolean quantidadeAvaliacao) {
		this.quantidadeAvaliacao = quantidadeAvaliacao;
	}
	
	public void verificarKilos() {
		System.out.println((this.auxAvaliacaoFisica.getResultado_gordura_ideal_maximo() * this.auxAvaliacaoFisica.getPeso_atual()) / 100 + "gordura ideal");
		System.out.println(this.auxAvaliacaoFisica.getPeso_atual());
		System.out.println(this.auxAvaliacaoFisica.getResultado_peso_ideal());
	}
	
	
	public void verificarCarencia() {
		Double calculo = auxAvaliacaoFisica.getResultado_gordura_ideal_minimo() - auxAvaliacaoFisica.getResultado_gordura_atual();
		auxAvaliacaoFisica.setResultado_gordura_ideal_maximo(calculo);
	}
	
}
	
	
